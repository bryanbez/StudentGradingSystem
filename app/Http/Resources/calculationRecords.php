<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class calculationRecords extends JsonResource
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
            'student_lrn' => $request->student_lrn,
            'quiz_count' => $request->quiz_count,
            'max_quiz_number' => $request->max_quiz_number,
            'equivalent' => $request->equivalent,
            'max_quiz_no_of_items' => $request->max_quiz_no_of_items
        ];
    }
}
