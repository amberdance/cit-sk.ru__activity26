<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Response;
use App\Interfaces\PollRepositoryInterface;
use Illuminate\Http\JsonResponse;

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

}
