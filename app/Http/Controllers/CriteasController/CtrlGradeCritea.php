<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;
use App\Models\CriteasModel\GradeCriteaModel;
use App\Http\Request;
use App\Http\Resources\CriteaResources;

use DB;

class CtrlGradeCritea extends Controller
{
  
    public function index()
    {
        $fetchAllGradeCritea = GradeCriteaModel::all();
        return CriteaResources::collection($fetchAllGradeCritea);

    }
    public function fetchAllStudentRecords($student_lrn, $subject_code) {

        $critea = new GradeCriteaModel();

        $fetchAllGradeCritea = DB::select('select id, critea, percentage from tblGradeCritea');
        foreach($fetchAllGradeCritea as $singleCritea) {

            if($singleCritea->critea == 'Assignment') {
                $assignmentRecord = $critea->calculateAssignmentRecords($student_lrn, $subject_code);
            }
            else if($singleCritea->critea == 'Exam') {
                $examRecord = $critea->calculateExamRecords($student_lrn, $subject_code);
            }
            else if($singleCritea->critea == 'Project') {
                $projectRecord = $critea->calculateProjectRecords($student_lrn, $subject_code);
            }
            else if($singleCritea->critea == 'Quiz') {
                $quizRecord = $critea->calculateQuizRecords($student_lrn, $subject_code);
            }
            else if($singleCritea->critea == 'Recitation') {
                $recitationRecord = $critea->calculateRecitationRecords($student_lrn, $subject_code);
            }
        
        }
  
        return response()->json([
            'quizRecords' => $quizRecord,
            'assignmentRecords' => $assignmentRecord,
            'examRecords' => $examRecord,
            'projectRecords' => $projectRecord, 
            'recitationRecords' => $recitationRecord
        ]); 
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(GradeCriteaModel $gradeCriteaModel)
    {
        //
    }

    public function edit(GradeCriteaModel $gradeCriteaModel)
    {
        //
    }

    public function update(Request $request, GradeCriteaModel $gradeCriteaModel)
    {
        //
    }

    public function destroy(GradeCriteaModel $gradeCriteaModel)
    {
        //
    }
}
