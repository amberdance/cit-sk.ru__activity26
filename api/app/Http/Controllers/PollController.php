<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Controllers\Controller;
use App\Http\Response;
use App\Interfaces\PollRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PollController extends Controller
{

    /**
     * @var PollRepositoryInterface
     */
    private $pollRepository;

    public function __construct(PollRepositoryInterface $pollRepository)
    {

        $this->pollRepository = $pollRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return Response::jsonSuccess($this->pollRepository->getAllPolls($request->filters, $request->limit));
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return Response::jsonSuccess([
            'poll'      => $this->pollRepository->getPollById($id),
            'questions' => $this->pollRepository->getPollQuestionsByPollId($id),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function vote(Request $request): JsonResponse
    {

        $request->validate([
            "userId"  => "required",
            "pollId"  => "required",
            "results" => "required",
        ]);

        if ($this->pollRepository->isUserVoted($request->userId, $request->pollId)) {
            return Response::jsonError(Constants::VOTED_BEFORE_CODE, Constants::VOTED_BEFORE_MESSAGE);
        };

        $this->pollRepository->vote($request->all());

        return Response::jsonSuccess();
    }

}
