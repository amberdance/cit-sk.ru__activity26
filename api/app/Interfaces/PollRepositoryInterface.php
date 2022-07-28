<?php
namespace App\Interfaces;

use App\Models\Polls\Poll;
use Illuminate\Database\Eloquent\Collection;

interface PollRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return Poll
     */
    public function store(array $params): Poll;

    /**
     * @return Collection
     */
    public function getAllPolls(): Collection;

    /**
     * @param int $id
     *
     * @return Poll
     */
    public function getPollById(int $id): Poll;

    /**
     * @param int $id
     *
     * @return Collection
     */
    public function getPollQuestionsByPollId(int $id): Collection;

    /**
     * @param int $pollId
     *
     * @return Collection
     */
    public function getResultsByPollId(int $pollId): array;

    /**
     * @param array $params
     *
     * @return void
     */
    public function vote(array $params): void;

    /**
     * @param int $userId
     * @param int $pollId
     *
     * @return bool
     */
    public function isUserVoted(int $userId, int $pollId): bool;

}
