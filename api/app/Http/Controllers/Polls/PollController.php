<?php

namespace App\Http\Controllers\Polls;

use App\Http\Controllers\Controller;
use App\Interfaces\Polls\PollRepositoryInterface;
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

    public function index()
    {
        return $this->pollRepository->getAllPolls();
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy()
    {
        //
    }
}
