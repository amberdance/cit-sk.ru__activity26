<?php
namespace App\Repositories\Polls;

use App\Interfaces\Polls\PollRepositoryInterface;
use App\Models\Polls\Poll;
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
            ->where('polls.is_active', 1)
            ->join('poll_categories', 'polls.category_id', '=', 'poll_categories.id')
            ->orderByDesc('created_at')
            ->take(4)
            ->get('label as category');
    }
}
