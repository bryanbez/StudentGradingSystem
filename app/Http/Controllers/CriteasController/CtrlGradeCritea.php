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
    public function fetchAllStudentRecords($student_lrn) {

     
        $critea = new GradeCriteaModel();

        $fetchAllGradeCritea = DB::select('select id, critea, percentage from tblGradeCritea');
        foreach($fetchAllGradeCritea as $singleCritea) {

            if($singleCritea->critea == 'Assignment') {
                $assignmentRecords = $critea->calculateAssignmentRecords($student_lrn);
            }
            else if($singleCritea->critea == 'Exam') {

                $examRecords = $critea->calculateExamRecords($student_lrn);
                
            }
            else if($singleCritea->critea == 'Project') {
                $projectRecords = $critea->calculateProjectRecords($student_lrn);
            }
            else if($singleCritea->critea == 'Quiz') {
                $quizRecords = $critea->calculateQuizRecords($student_lrn);
            }
            else if($singleCritea->critea == 'Recitation') {
                $recitationRecords = $critea->calculateRecitationRecords($student_lrn);
            }
        }

        return response()->json([
            'assignmentRecords' => $assignmentRecords,
            'examRecords' => $examRecords,
            'projectRecords' => $projectRecords,
            'quizRecords' => $quizRecords,
            'recitationRecords' => $recitationRecords
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
