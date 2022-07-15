<?php
namespace App\Repositories;

use App\Interfaces\PollRepositoryInterface;
use App\Models\Polls\Poll;
use App\Models\Polls\PollQuestion;
use App\Models\Polls\PollResult;
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
    public function getAllPolls(): Collection
    {
        return Poll::select("polls.*", "poll_categories.label as category")
            ->where([
                'polls.is_active'    => 1,
                'polls.is_completed' => 0,
            ])
            ->join('poll_categories', 'polls.category_id', '=', 'poll_categories.id')
            ->orderByDesc('created_at')
            ->take(4)
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
                'polls.is_active'    => 1,
                'polls.is_completed' => 0,
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

        foreach ($params['variants'] as $questionId => $variantId) {
            PollResult::create([
                'user_id'     => $params['userId'],
                'poll_id'     => $params['pollId'],
                'question_id' => $questionId,
                'variant_id'  => $variantId,
            ]);
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
        return boolval(PollResult::select("id")
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
        return PollResult::all('id')->count();
    }
}
