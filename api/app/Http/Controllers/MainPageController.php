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

        return Response::jsonSuccess([
            'passed_polls_count' => PollRepository::getPassedPollsCount(),
            'polls_count'        => PollRepository::getPollsCount(),
            'users_count'        => UserRepository::getUsersCount(),
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
