<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_name' => $this->parent_name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'education_level' => $this->education_level,
            'class' => $this->class,
            'name' => $this->name,
            'password' => $this->password,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
