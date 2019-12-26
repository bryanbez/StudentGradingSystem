<?php

namespace App\Http\Controllers\CriteasController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CriteasModel\StudQuizModel as QuizModel;
use App\Http\Resources\calculationRecords;
use App\Models\CriteasModel\GradeCriteaModel;
use DB;

class CtrlStudentQuiz extends Controller
{
   
    public function index()
    {
         
    }

    public function fetchQuizRecordByStudentId($student_lrn, $subject_code) 
    {
        $fetchAllQuizRecord = QuizModel::where('student_lrn', $student_lrn)->where('subj_code', $subject_code)->get();
        $gradeCritea = new GradeCriteaModel();
        $quizResult = $gradeCritea->calculateQuizRecords($student_lrn, $subject_code);

        return response()->json([
            'overallData' => $quizResult,
            'quizzez' => $fetchAllQuizRecord
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $saveQuiz = new QuizModel;
            $saveQuiz->student_lrn = $request->student_lrn;
            $saveQuiz->subj_code = $request->subj_code;
            $saveQuiz->date_of_quiz = $request->dateOfQuiz;
            $saveQuiz->no_of_items = $request->noOfItems;
            $saveQuiz->score = $request->score;
            $saveQuiz->equivalent = ($request->score * 100) / $request->noOfItems;
            $saveQuiz->save();

            return response()->json('Quiz Information Saved');
        }
        catch(Exception $e) {
            return response()->json('Quiz inserting exam record', $e);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $showSecificRecord = QuizModel::where('quiz_id', $id)->get();
        return response()->json($showSecificRecord);
    }

    public function update(Request $request, $id)
    {
        $updateExamRecord = QuizModel::where('quiz_id', $id)->update([
            'date_of_quiz' => $request->dateOfQuiz,
            'no_of_items' => $request->noOfItems,
            'score' => $request->score,
            'equivalent' => ($request->score * 100) / $request->noOfItems
        ]);
        return response()->json('Quiz Record Successfully Updated');
    }

    public function destroy($id)
    {
        $removeQuizRecord = QuizModel::where('quiz_id', $id)->delete();
        return response()->json('Quiz Record Delete Successfully');
    }
}
