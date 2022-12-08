<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Lib\NewsRss;
use App\Repositories\PollRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainPageController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function getCounters(): JsonResponse
    {

        $counters = Response::jsonSuccess([
            'passed_polls_count' => PollRepository::getPassedPollsCount(),
            'polls_count'        => PollRepository::getPollsCount(),
            'users_count'        => UserRepository::getUsersCount(),
        ]);

        return Cache::remember("counters", 3600, fn() => $counters);
    }

    /**
     * @return JsonResponse
     */
    public function getNews(Request $request): JsonResponse
    {

        return Response::jsonSuccess(NewsRss::news1777ru($request->limit ?? null));

    }
}
