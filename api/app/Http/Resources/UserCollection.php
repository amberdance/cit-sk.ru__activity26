<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{

    public function toArray($request)
    {

        return [
            'users'      => $this->collection,
            'pagination' => new PaginationResource($this),
        ];
    }
}
