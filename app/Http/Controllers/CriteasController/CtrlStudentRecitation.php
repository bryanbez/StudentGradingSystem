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
        $fetchAllRecitationRecord = RecitationModel::where('student_lrn', $student_lrn)->get();

        $recitationResult = DB::select("SELECT student_lrn, SUM(points) AS recitation_count,
        CASE WHEN SUM(points) >= 10 THEN '100' 
                WHEN (SUM(points) >= 7 AND SUM(points) <= 9) THEN '90' 
                WHEN (SUM(points) >= 4 AND SUM(points) <= 6) THEN '85' 
                WHEN (SUM(points) >= 2 AND SUM(points) <= 3) THEN '80' 
                WHEN SUM(points) = 1 THEN '75' 
                ELSE '65' 
        END AS equivalent   
        FROM tblRecitation WHERE student_lrn=$student_lrn AND subj_code='$subject_code' GROUP BY student_lrn");

        if($fetchAllRecitationRecord->isEmpty()) {
            $noResult = new GradeCriteaModel();
            return [
                'overAllRecitationResult' => $noResult->returnNoResult($student_lrn, 'recitation_count', 'Recitation', $subject_code)
            ];
        }
        else {
            return response()->json([
                'overAllRecitationResult' => $recitationResult,
                'recitationRecords' => $fetchAllRecitationRecord
             ]);
        }
        
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
