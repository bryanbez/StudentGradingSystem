<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\calculationRecords;

class QuizResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);
         return [
             'student_lrn' => $this->student_lrn,
             'quiz_count' => new calculationRecords($this->quiz_count),
            // 'max_quiz_count' => $request->max_quiz_count,
            // 'total_equivalent' => $request->total_equivalent,
            'quiz_records' => [
                    'quiz_id' => $this->quiz_id,
                    'date_of_quiz' => $this->date_of_quiz,
                    'no_of_items' => $this->no_of_items,
                    'score' => $this->score,
            ]
            
        ];
        
    }
}
