<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Lib\NewsRss;
use App\Repositories\PollRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainPageController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function getCounters(): JsonResponse
    {

        $pollRepository = new PollRepository;

        return Response::jsonSuccess([
            'passed_polls_count' => $pollRepository->getPassedPollsCount(),
            'polls_count'        => $pollRepository->getPollsCount(),
            'users_count'        => (new UserRepository)->getUsersCount(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getNews(Request $request): JsonResponse
    {

        return Response::jsonSuccess(NewsRss::news1777ru($request->limit ?? null));

    }
}
