<?php
namespace App\Repositories;

use App\Interfaces\PollRepositoryInterface;
use App\Models\Polls\Poll;
use App\Models\Polls\PollAnswer;
use App\Models\Polls\PollQuestion;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function getAllPolls(?array $params = null, ?int $limit = null): Collection
    {

        $select = Poll::select("polls.*", "poll_categories.label as category")
            ->join('poll_categories', 'polls.category_id', '=', 'poll_categories.id')
            ->orderByDesc('created_at');

        if (is_array($params)) {
            if (in_array('completed', $params)) {
                $select->where('polls.is_completed', true);
            }

            if (in_array('available', $params)) {
                $select->where('polls.is_completed', false);

            }
        }

        if ($limit) {
            $select->take($limit);
        }

        return $select->where('polls.is_active', true)
            ->where('polls.active_to', '=', null)
            ->orWhere('polls.active_to', '>=', date('Y-m-d H:i:s'))
            ->get('label as category');
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
                'polls.id'           => $id,
                'polls.is_active'    => true,
                'polls.is_completed' => false,
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

        $questions = PollQuestion::where('poll_id', $id)->get();

        //TO DO: Сделать проверку на пустую коллекцию
        foreach ($questions as $question) {
            $question->variants;

        }

        return $questions;
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
                    'user_answer' => $answer['input'] ?? null,
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
     * @param bool $onlyActive
     *
     * @return int
     */
    public function getPollsCount(bool $onlyActive = false): int
    {
        $result = 0;

        if ($onlyActive) {
            $result = Poll::select('id')->where('is_active', true)->count();
        } else {
            $result = Poll::all('id')->count();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getPassedPollsCount(): int
    {
        return PollAnswer::all('id')->count();
    }
}
