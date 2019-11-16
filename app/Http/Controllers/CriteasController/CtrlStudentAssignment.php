<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CriteasModel\StudAssignmentModel as AssignmentModel;
use App\Http\Resources\StudentAssignmentResources;
use DB;

class CtrlStudentAssignment extends Controller
{

    public function index()
    {
        //
    }

    public function fetchAssignmentRecordByStudentId($student_lrn)
    {
        $fetchAllAssignmentRecord = AssignmentModel::where('student_lrn', $student_lrn)->get();
       
        $assignmentResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS assignment_count, 
        (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_assignment_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblAssignment GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblAssignment WHERE student_lrn=$student_lrn))
          * 65 + (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment WHERE student_lrn=$student_lrn)
         END) AS equivalent   
        FROM tblAssignment WHERE student_lrn=$student_lrn GROUP BY student_lrn");

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
