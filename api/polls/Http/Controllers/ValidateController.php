<?php
namespace RegionalPolls\Http\Controllers;

final class ValidateController extends Controller
{

    /**
     * @var \RegionalPolls\Models\Validate
     */
    protected $model;

    public function validate(): void
    {
        $this->error(1);
    }

    public function vote(): void
    {

    }
}
