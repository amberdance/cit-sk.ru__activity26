<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Repositories\PollRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class MainPageController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function getCounters(): JsonResponse
    {

        $pollRepository = new PollRepository;
        $user           = new UserRepository;

        $passedPollsCount = $pollRepository->getPassedPollsCount();
        $pollsCount       = $pollRepository->getPollsCount();
        $usersCount       = $user->getUsersCount();

        if (env('USE_BOOSTED_STATISTICS')) {
            $usersCount       = round($usersCount + 1 * env('USERS_COUNT_RATIO'));
            $passedPollsCount = round(($usersCount * $passedPollsCount * $pollsCount) / 2.5);
        }

        return Response::jsonSuccess([
            'passed_polls_count' => $passedPollsCount,
            'polls_count'        => $pollsCount,
            'users_count'        => $usersCount,
        ]);
    }
}
