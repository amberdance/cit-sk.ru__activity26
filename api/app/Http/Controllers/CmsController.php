<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Repositories\PollRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class CmsController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function dashboard(): JsonResponse
    {

        return Response::jsonSuccess([
            'users'      => UserRepository::getUserRegistrationCounters(),
            'population' => UserRepository::getUserPopulationCounters(),
            'polls'      => [
                'passed_count' => PollRepository::getPassedPollsCount(),
                'total_count'  => PollRepository::getPollsCount(),
                'categories'   => PollRepository::getPollsByCategoryCount(),
            ],
        ]);
    }

}
