<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

        $user = auth()->user();

        return [
            $this->mergeWhen($user->is_admin, [
                'id'                => $this->id,
                'associate_id'      => $this->associate_id,
                'district_id'       => $this->district_id,
                'first_name'        => $this->first_name,
                'last_name'         => $this->last_name,
                'address'           => $this->address,
                'patronymic'        => $this->patronymic,
                'phone'             => $this->phone,
                'birthday'          => $this->birthday,
                'email'             => $this->email,
                'email_verified_at' => $this->email_verified_at,
                'created_at'        => $this->created_at,
                'updated_at'        => $this->updated_at,
                'is_verified'       => $this->is_verified,
                'is_admin'          => $this->is_admin,
                'is_active'         => $this->is_active,
                'is_associated'     => $this->is_associated,
            ]),
        ];
    }
}
