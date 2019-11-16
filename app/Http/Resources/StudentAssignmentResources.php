<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAssignmentResources extends JsonResource
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
            'student_lrn' => $this->student_lrn,
            'assignmentInfo' => [
                'assignment_id' => $this->assignment_id,
                'dateOfAssignment' => $this->date_of_assignment,
                'grade' => $this->grade,      
            ],
        ];
    }
}
