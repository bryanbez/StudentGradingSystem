<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CriteasModel\StudAssignmentModel as AssignmentModel;
use App\Http\Resources\StudentAssignmentResources;
use App\Models\CriteasModel\GradeCriteaModel;
use DB;

class CtrlStudentAssignment extends Controller
{

    public function index()
    {
        //
    }

    public function fetchAssignmentRecordByStudentId($student_lrn, $subject_code)
    {
        $fetchAllAssignmentRecord = AssignmentModel::where('student_lrn', $student_lrn)->where('subj_code', $subject_code)->get();
        $gradeCritea = new GradeCriteaModel();
        $assignmentResult = $gradeCritea->calculateAssignmentRecords($student_lrn, $subject_code);
        return response()->json([
            'overallData' => $assignmentResult,
            'assignments' => $fetchAllAssignmentRecord
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $saveAssignment = new AssignmentModel;
            $saveAssignment->student_lrn = $request->student_lrn;
            $saveAssignment->date_of_assignment = $request->dateOfAssignment;
            $saveAssignment->subj_code = $request->subj_code;
            $saveAssignment->grade = $request->grade;
            $saveAssignment->save();

            return response()->json('Assignment Record Information Saved');
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
        $showSecificRecord = AssignmentModel::where('assignment_id', $id)->get();
        return response()->json($showSecificRecord);
    }

    public function update(Request $request, $id)
    {
    
        $updateAssignmentRecord = AssignmentModel::where('assignment_id', $id)->update([
            'date_of_assignment' => $request->dateOfAssignment,
            'grade' => $request->grade,
        ]);
        return response()->json('Assignment Record Successfully Updated');
    }

    public function destroy($id)
    {
        $removeAssignmentRecord = AssignmentModel::where('assignment_id', $id)->delete();
        return response()->json('Assignment Record Delete Successfully');
    }
}
