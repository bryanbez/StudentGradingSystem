<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CriteasModel\StudProjectModel as ProjModel;
use App\Models\CriteasModel\GradeCriteaModel;
use DB;

class CtrlStudentProject extends Controller
{

    public function index()
    {
        //
    }

    public function fetchProjectRecordByStudentId($student_lrn, $subject_code) {
        $fetchAllProjectRecord = ProjModel::where('student_lrn', $student_lrn)
                                            ->where('subj_code', $subject_code)->get();

        $gradeCritea = new GradeCriteaModel();

        $projectRecord = $gradeCritea->calculateProjectRecords($student_lrn, $subject_code);

        // $projectResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS project_count, 
        // (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_project_number,
        // (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblProjects GROUP BY student_lrn LIMIT 1) 
        //  THEN (((SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
        //     - (SELECT COUNT(student_lrn) FROM tblProjects WHERE student_lrn=$student_lrn))
        //   * 65 + (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn)) 
        //   /  (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        // /* LOWER */
        //  ELSE (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS project_count FROM tblProjects WHERE student_lrn=$student_lrn)
        //  END) AS equivalent   
        // FROM tblProjects WHERE student_lrn=$student_lrn GROUP BY student_lrn");

       return response()->json([
            'projectData' => $projectRecord,
            'projectRecords' => $fetchAllProjectRecord
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
     
        try {
            $saveProject = new ProjModel;
            $saveProject->student_lrn = $request->student_lrn;
            $saveProject->subj_code = $request->subj_code;
            $saveProject->date_of_project = $request->dateOfProject;
            $saveProject->grade = $request->grade;
            $saveProject->save();

            return response()->json('Project Information Saved');
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
        $showSecificRecord = ProjModel::where('project_id', $id)->get();
        return response()->json($showSecificRecord);
    }

    public function update(Request $request, $id)
    {
        $updateProjectRecord = ProjModel::where('project_id', $id)->update([
            'date_of_project' => $request->dateOfProject,
            'grade' => $request->grade,
        ]);
        return response()->json('Project Record Successfully Updated');
    }

    public function destroy($id)
    {
        $removeProjectRecord = ProjModel::where('project_id', $id)->delete();
        return response()->json('Project Record Delete Successfully');
    }
}
