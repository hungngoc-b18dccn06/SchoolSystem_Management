<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListGradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $teacher = [
            'id' => $this->teacher->id,
            "user" => [
                'id' => $this->id,
                "first_name" => $this->first_name,
                "last_name"  => $this->last_name,
            ]
        ];

       return [
        'id' => $this->id,
        'teacher_id' => $this->teacher_id,
        "class_numeric"=>$this->class_numeric,
        "class_name" =>$this->class_name,
        "class_description"=>$this->class_description,
        "student_count" => $this->students_count,
        "user" => [
            'id' => $this->id,
            "first_name" => $this->teacher->user->first_name,
            "last_name"  => $this->teacher->user->last_name,
        ]

       ];
    }
}
