<?php
namespace RegionalPolls\Http\Controllers;

use RegionalPolls\Http\Request;
use RegionalPolls\Http\Response;

class Controller extends Response
{

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request, $model)
    {

        $this->model   = new $model;
        $this->request = $request;

    }
}
