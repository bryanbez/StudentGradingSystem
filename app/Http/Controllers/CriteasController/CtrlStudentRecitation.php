<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CriteasModel\StudRecitationModel as RecitationModel;
use App\Models\CriteasModel\GradeCriteaModel;
use DB;

class CtrlStudentRecitation extends Controller
{
  
    public function index()
    {
        //
    }

    public function fetchRecitationRecordByStudentId($student_lrn, $subject_code) 
    {
        $fetchAllRecitationRecord = RecitationModel::where('student_lrn', $student_lrn)->where('subj_code', $subject_code)->get();
        $gradeCritea = new GradeCriteaModel();
        $recitationResult = $gradeCritea->calculateRecitationRecords($student_lrn, $subject_code);
        
        return response()->json([
            'overAllRecitationResult' => $recitationResult,
            'recitationRecords' => $fetchAllRecitationRecord
         ]);
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $saveRecitation = new RecitationModel;
            $saveRecitation->student_lrn = $request->student_lrn;
            $saveRecitation->date_of_recitation = $request->dateOfRecitation;
            $saveRecitation->subj_code = $request->subj_code;
            $saveRecitation->points = $request->points;
            $saveRecitation->save();

            return response()->json('Recitation Information Saved');
        }
        catch(Exception $e) {
            return response()->json('Error inserting exam record', $e);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $showSecificRecord = RecitationModel::where('recitation_id', $id)->get();
        return response()->json($showSecificRecord);
    }

    public function update(Request $request, $id)
    {
        $updateProjectRecord = RecitationModel::where('recitation_id', $id)->update([
            'date_of_recitation' => $request->dateOfRecitation,
            'points' => $request->points,
        ]);
        return response()->json('Recitation Record Successfully Updated');
    }

    public function destroy($id)
    {
        $removeRecitationRecord = RecitationModel::where('recitation_id', $id)->delete();
        return response()->json('Recitation Record Delete Successfully');
    }
}
