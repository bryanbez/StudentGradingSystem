<?php

namespace App\Http\Controllers\StudentInfoController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentInfosModel\SummaryOfStudents;

class SummaryOfStudentsController extends Controller
{
    public function getTheSummary() {

        $summary = new SummaryOfStudents();

        return response()->json([
            'count' => [
                'students' => $summary->getAllStudentsCount()[0],
                'maleStudents' => $summary->getAllMaleStudentsCount()[0],
                'femaleStudents' => $summary->getAllFemaleStudentsCount()[0],
                'firstYearStudents' => $summary->getAllFirstYearStudentsCount()[0],
                'secondYearStudents' => $summary->getAllSecondYearStudentsCount()[0],
                'thirdYearStudents' => $summary->getAllThirdYearStudentsCount()[0],
                'fourthYearStudents' => $summary->getAllFourthYearStudentsCount()[0]
            ]
        ]);

    }
}
