<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentGradeAndCritea extends JsonResource
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
            'examInfo' => [
                'exam_id' => $this->exam_id,
                'dateOfExam' => $this->date_of_exam,
                'noOfItems' => $this->no_of_items,
                'score' => $this->score,
                'equivalent' => $this->equivalent 
                   
            ],
            // 'critea_list' => [
            //     new CriteaResources($this)
            // ]
           
         
          
        ];
    }

    // public function with($request) {
    //     return [
    //         'critea' => new CriteaResources($this),
    //     ];
    // }
}
