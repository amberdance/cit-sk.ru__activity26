<?php
namespace App\Repositories;

use App\Interfaces\PollRepositoryInterface;
use App\Models\Polls\Poll;
use App\Models\Polls\PollAnswer;
use App\Models\Polls\PollQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PollRepository implements PollRepositoryInterface
{

    /**
     * @param array $params
     *
     * @return Poll
     */
    public function store(array $params): Poll
    {
        return Poll::create($params);
    }

    /**
     * @return mixed
     */
    public function getAllPolls(?array $params = null): mixed
    {

        return Poll::handleSharedCache(function () use ($params) {
            $select = Poll::select()
                ->with("category")
                ->where('is_active', true)
                ->where('active_to', '=', null)
                ->orWhere('active_to', '>=', date('Y-m-d H:i:s'))
                ->orderBy('sort')
                ->orderByDesc('created_at');

            if ($params) {
                if (isset($params['filter'])) {
                    if ($params['filter'] == 'completed') {
                        $select->where('polls.is_completed', true);
                    }

                    if ($params['filter'] == 'available') {
                        $select->where('polls.is_completed', false);
                    }
                }

                if (isset($params['limit'])) {
                    $select->take($params['limit']);
                }
            }

            return isset($params['perPage']) ? $select->paginate($params['perPage']) : $select->get();
        }, 86400, $params);
    }

    /**
     * @param int $id
     *
     * @return Poll
     */
    public function getPollById(int $id): Poll
    {
        return Poll::select("polls.*", "poll_categories.label as category")
            ->where([
                'polls.id'        => $id,
                'polls.is_active' => true,
            ])
            ->join('poll_categories', 'polls.category_id', '=', 'poll_categories.id')
            ->firstOrFail('label as category');
    }

    /**
     * @param int $id
     *
     * @return Collection
     */
    public function getPollQuestionsByPollId(int $id): Collection
    {

        return PollQuestion::select(["id", "label", "type"])->with('variants')->where('poll_id', $id)->get();

    }

    /**
     * @param array $params
     *
     * @return void
     */
    public function vote(array $params): void
    {

        foreach ($params['values'] as $question) {
            foreach ($question['answer'] as $answer) {
                PollAnswer::create([
                    'user_id'     => $params['userId'],
                    'poll_id'     => $params['pollId'],
                    'question_id' => $question['id'],
                    'variant_id'  => $answer['id'],
                    'user_answer' => isset($answer['input']) ? html_entity_decode(strip_tags($answer['input'])) : null,
                ]);
            }
        }
    }

    /**
     * @param int $userId
     * @param int $pollId
     *
     * @return bool
     */
    public function isUserVoted(int $userId, int $pollId): bool
    {
        return boolval(PollAnswer::select("id")
                ->where([
                    'user_id' => $userId,
                    'poll_id' => $pollId,
                ])
                ->first());
    }

    /**
     * @param int $pollId
     *
     * @return array
     */
    public function getResultsByPollId(int $pollId): array
    {

        $cachedResult = Cache::get("poll_result");

        if (isset($cachedResult["poll"])) {
            if ($cachedResult["poll"]["id"] == $pollId) {
                return $cachedResult;
            } else {
                Cache::forget("poll_result");
            }
        }

        $result = [
            'poll'      => $this->getPollById($pollId),
            'questions' => PollQuestion::select()
                ->with(["variants"])
                ->where("poll_id", $pollId)
                ->get(),
        ];

        $result['poll']['total_answers_count'] = PollAnswer::select('id')->where('poll_id', $pollId)->count();

        foreach ($result['questions'] as $i => $question) {

            $answersCount = PollAnswer::select('id')
                ->where('question_id', $question['id'])
                ->count();

            foreach ($question['variants'] as $k => $variant) {
                if ($variant['has_user_answer']) {
                    $result['questions'][$i]['variants'][$k]['answers'] = $this->getInputAnswers($variant['question_id']);
                } else {
                    $variantAnswersCount = PollAnswer::select('id')
                        ->where('variant_id', $variant['id'])
                        ->count();

                    $result['questions'][$i]['variants'][$k]['answers_count'] = $variantAnswersCount;
                    $result['questions'][$i]['variants'][$k]['percent']       = $variantAnswersCount == 0 ? 0 : round(($variantAnswersCount / $answersCount) * 100, 1);
                }

            }
        }

        Cache::put("poll_result", $result, 300);

        return $result;

    }

    /**
     * @param int $questionId
     *
     * @return Collection
     */
    public function getInputAnswers(int $questionId): Collection
    {
        return PollAnswer::select(["id", "user_answer"])->where("question_id", $questionId)->get();
    }

    /**
     * @param bool $onlyActive
     *
     * @return int
     */
    public static function getPollsCount(bool $onlyActive = true): int
    {
        $result = 0;

        if ($onlyActive) {
            $result = Poll::select('id')->where('is_active', true)->count();
        } else {
            $result = Poll::select('id')->count();
        }

        return $result;
    }

    /**
     * @return int
     */
    public static function getPassedPollsCount(bool $isCountDeletedUsers = true): int
    {
        $result = 0;

        if ($isCountDeletedUsers) {
            $result = PollAnswer::select('id')->count();
        } else {
            $result = PollAnswer::select('poll_answers.id')->join('users', 'users.id', '=', 'poll_answers.user_id')->count();
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getPollsByCategoryCount(): array
    {
        return Poll::select(DB::raw("COUNT(polls.id) as count"), 'category.label')
            ->leftJoin('poll_categories as category', 'category.id', '=', 'polls.category_id')
            ->orderByDesc('count')
            ->groupBy('category.id')
            ->get()
            ->toArray();
    }

}
