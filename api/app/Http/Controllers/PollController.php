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
    public function index(): JsonResponse
    {
        return Response::jsonSuccess($this->pollRepository->getAllPolls());
    }

    public function show(int $id)
    {
        return Response::jsonSuccess([
            'poll'      => $this->pollRepository->getPollById($id),
            'questions' => $this->pollRepository->getPollQuestionsByPollId($id),
        ]);
    }

    public function vote(Request $request)
    {

        $request->validate([
            "user"     => "required",
            "variants" => "required",
        ]);

        if ($this->pollRepository->isUserVoted($request->user, $request->poll)) {
            return Response::jsonError(Constants::VOTED_BEFORE_CODE, Constants::VOTED_BEFORE_MESSAGE);
        };

        $this->pollRepository->vote($request->all());

        return Response::jsonSuccess();
    }

}
