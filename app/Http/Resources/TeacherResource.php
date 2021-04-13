<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'name' => $this->name,
            'qualification' => $this->qualification,
            'educational_card_number' => $this->educational_card_number,
            'educational_card_picture' => $this->educational_card_picture,
            'class' => $this->class,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'password' => $this->password,
            'subjects' => $this->subjects,
        ];
    }
}
