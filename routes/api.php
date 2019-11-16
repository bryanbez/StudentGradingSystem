<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resources([
    'students' => 'StudentInfoController\CtrlStudentInformation',
    'exams' => 'CriteasController\CtrlStudentExam',
    'criteas' => 'CriteasController\CtrlGradeCritea',
    'assignments' => 'CriteasController\CtrlStudentAssignment',
    'projects' => 'CriteasController\CtrlStudentProject',
    'quiz' => 'CriteasController\CtrlStudentQuiz',
    'recitation' => 'CriteasController\CtrlStudentRecitation'
]);

Route::get('fetchexams/{student_lrn}', 'CriteasController\CtrlStudentExam@fetchExamRecordByStudentId');
Route::get('fetchassignments/{student_lrn}', 'CriteasController\CtrlStudentAssignment@fetchAssignmentRecordByStudentId');
Route::get('fetchprojects/{student_lrn}', 'CriteasController\CtrlStudentProject@fetchProjectRecordByStudentId');
Route::get('fetchquiz/{student_lrn}', 'CriteasController\CtrlStudentQuiz@fetchQuizRecordByStudentId');
Route::get('fetchrecitation/{student_lrn}', 'CriteasController\CtrlStudentRecitation@fetchRecitationRecordByStudentId');
Route::get('fetchStudentRecords/{student_lrn}', 'CriteasController\CtrlGradeCritea@fetchAllStudentRecords');

Route::get('student/{student_lrn}', 'StudentInfoController\CtrlStudentInformation@show');
