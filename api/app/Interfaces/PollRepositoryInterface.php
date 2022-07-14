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
     * @param array $params
     *
     * @return void
     */
    public function vote(array $params): void;

    /**
     * @param string $uuid
     * @param int $pollId
     * 
     * @return bool
     */
    public function isUserVoted(string $uuid, int $pollId): bool;

}
