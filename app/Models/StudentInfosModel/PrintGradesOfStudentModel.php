<?php

namespace App\Models\StudentInfosModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\CriteasModel\GradeCriteaModel;

class PrintGradesOfStudentModel extends Model
{
    protected $table = "tblStudentInfo";
    protected $guarded = [];

    public function getAllStudentGradesBasedOnYearAndSection($year, $section, $subject) {

        $getAllStudent = DB::select("SELECT * FROM tblStudentInfo WHERE schoolYear=$year AND section=$section ORDER BY studentLastName");
        $array = [];

        foreach($getAllStudent as $fetchData) {

            $callGradeCriteaModel = new GradeCriteaModel();

            $examRecords = $callGradeCriteaModel->calculateExamRecords($fetchData->student_lrn, $subject);
            $assignmentRecords = $callGradeCriteaModel->calculateAssignmentRecords($fetchData->student_lrn, $subject);
            $projectRecords = $callGradeCriteaModel->calculateProjectRecords($fetchData->student_lrn, $subject);
            $quizRecords = $callGradeCriteaModel->calculateQuizRecords($fetchData->student_lrn, $subject);
            $recitationRecords = $callGradeCriteaModel->calculateRecitationRecords($fetchData->student_lrn, $subject);

            // $getTheEquivalent = [
            //     'student_lrn' => $fetchData->student_lrn,
            //     'criteas' => [
            //       'exam' => $examRecords[0],
            //       'assignment' => $assignmentRecords[0],
            //       'project' => $projectRecords[0],
            //       'quiz' => $quizRecords[0],
            //       'recitation' => $recitationRecords[0],
            //     ]   
            // ];
            // array_push($array, $getTheEquivalent);
            dd($examRecords);
        }
     

       
    }

   

}
