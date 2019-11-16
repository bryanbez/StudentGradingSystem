<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CriteasModel\StudExamModel as ExamModel;
use App\Models\CriteasModel\GradeCriteaModel;
use DB;

class CtrlStudentExam extends Controller
{
   
    public function index()
    {
        $fetchAllExamRecord = ExamModel::all();
        return StudentscoreAndCritea::collection($fetchAllExamRecord);
    }

    public function fetchExamRecordByStudentId($student_lrn)
    {
        $fetchAllExamRecord = ExamModel::where('student_lrn', $student_lrn)->get();

        $examResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS exam_count, 
        (SELECT COUNT(student_lrn) AS exam_count FROM tblExam GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_exam_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) 
         THEN ((((SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) - (SELECT COUNT(student_lrn) FROM tblExam WHERE student_lrn=$student_lrn)) 
        * 65) + (((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn))) 
        / (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) /* LOWER */
         ELSE ((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn)
         END) AS equivalent   
        FROM tblExam WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if($fetchAllExamRecord->isEmpty()) {
            $noResult = new GradeCriteaModel();
            return [
                'overallExamData' => $noResult->returnNoResult($student_lrn, 'exam_count', 'Exam')
            ];
        }
        else {
            return response()->json([
                'overallExamData' => $examResult,
                'exams' => $fetchAllExamRecord
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
            $saveExam = new ExamModel;
            $saveExam->student_lrn = $request->student_lrn;
            $saveExam->date_of_exam = $request->dateOfExam;
            $saveExam->no_of_items = $request->noOfItems;
            $saveExam->score = $request->score;
            $saveExam->equivalent = ($request->score * 100) / $request->noOfItems;

            $saveExam->save();

            return response()->json('Exam Information Saved');
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
        $showSecificRecord = ExamModel::where('exam_id', $id)->get();
        return response()->json($showSecificRecord);
    }

    public function update(Request $request, $id)
    {
        $updateExamRecord = ExamModel::where('exam_id', $id)->update([
            'date_of_exam' => $request->dateOfExam,
            'no_of_items' => $request->noOfItems,
            'score' => $request->score,
            'equivalent' => ($request->score * 100) / $request->noOfItems
        ]);
        return response()->json('Exam Record Successfully Updated');
    }

    public function destroy($id)
    {
        $removeExamRecord = ExamModel::where('exam_id', $id)->delete();
        return response()->json('Exam Record Delete Successfully');
    }
}
