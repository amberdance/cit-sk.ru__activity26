<?php
namespace App\Interfaces\Polls;

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
     * @return Poll
     */
    public function getAllPolls(): Collection;

}
