<?php

return [
    '/validate' => [
        'GET',
        \RegionalPolls\Http\Controllers\ValidateController::class,
    ],

    '/vote'     => [
        'POST',
        \RegionalPolls\Http\Controllers\ValidateController::class,
    ],
];
