<?php

namespace App\Models\CriteasModel;

use Illuminate\Database\Eloquent\Model;
use DB;


class GradeCriteaModel extends Model
{
    protected $table = 'tblGradeCritea';
    protected $guarded = [];

    public function calculateExamRecords($student_lrn, $subject_code) {

        $examResult = DB::select(
        "SELECT student_lrn, COUNT(student_lrn) AS exam_count,
        (SELECT CONCAT(studentLastName, ' ', studentFirstName) FROM tblstudentinfo WHERE student_lrn=$student_lrn) AS studentFullName,
        (SELECT critea FROM tblGradeCritea WHERE critea='Exam') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Exam') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS exam_count FROM tblExam GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_exam_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) 
         THEN ((((SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) - (SELECT COUNT(student_lrn) FROM tblExam WHERE student_lrn=$student_lrn)) 
        * (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Exam')) + (((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn))) 
        / (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) /* LOWER */
         ELSE ((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn)
         END) AS finalGrade,
        (((SELECT percentage FROM tblGradeCritea WHERE critea='Exam') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) 
         THEN ((((SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) - (SELECT COUNT(student_lrn) FROM tblExam WHERE student_lrn=$student_lrn)) 
        * (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Exam')) + (((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn))) 
        / (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) /* LOWER */
         ELSE ((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn)
         END)) / 100) as equivalent    
        FROM tblExam WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($examResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'exam_count', 'Exam', $subject_code);
        }
        else {
            return $examResult;
        }

    }
    public function calculateAssignmentRecords($student_lrn, $subject_code) {

        $assignmentResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS assignment_count, 
        (SELECT CONCAT(studentFirstName, ' ', studentLastName) FROM tblstudentinfo WHERE student_lrn=$student_lrn) AS studentFullName,
        (SELECT critea FROM tblGradeCritea WHERE critea='Assignment') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Assignment') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_assignment_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblAssignment GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblAssignment WHERE student_lrn=$student_lrn))
          * (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Assignment') + (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment WHERE student_lrn=$student_lrn)
         END) AS finalGrade,
         (((SELECT percentage FROM tblGradeCritea WHERE critea='Assignment') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblAssignment GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblAssignment WHERE student_lrn=$student_lrn))
          * (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Assignment') + (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment WHERE student_lrn=$student_lrn)
         END)) / 100) as equivalent
        FROM tblAssignment WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($assignmentResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'assignment_count', 'Assignment', $subject_code);
        }
        else {
          return $assignmentResult;
        }

    }
    public function calculateProjectRecords($student_lrn, $subject_code) {

        $projectResult = DB::select("SELECT student_lrn, subj_code, COUNT(student_lrn) AS project_count,
        (SELECT CONCAT(studentFirstName, ' ', studentLastName) FROM tblstudentinfo WHERE student_lrn=$student_lrn) AS studentFullName,
        (SELECT critea FROM tblGradeCritea WHERE critea='Project') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Project') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_project_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblProjects GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code'))
          * (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Project') + (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code')) 
          /  (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
         ELSE (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code') / (SELECT COUNT(student_lrn) AS project_count FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code')
         END) AS finalGrade,
        (((SELECT percentage FROM tblGradeCritea WHERE critea='Project') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblProjects GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code'))
          * (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Project') + (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code')) 
          /  (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
         ELSE (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code') / (SELECT COUNT(student_lrn) AS project_count FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code')
         END)) / 100) AS equivalent
        FROM tblProjects WHERE student_lrn=$student_lrn AND subj_code='$subject_code'");
 
        if($projectResult[0]->student_lrn === null) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'project_count', 'Project', $subject_code);
        }
        else {
          return $projectResult;
        }

      
    }
    public function calculateQuizRecords($student_lrn, $subject_code) {

        $quizResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS quiz_count,
        (SELECT CONCAT(studentFirstName, ' ', studentLastName) FROM tblstudentinfo WHERE student_lrn=$student_lrn) AS studentFullName, 
        (SELECT critea FROM tblGradeCritea WHERE critea='Quiz') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Quiz') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS quiz_count FROM tblQuiz GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_quiz_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblQuiz GROUP BY student_lrn LIMIT 1) 
         THEN (SUM(score) * 100) / (SELECT SUM(no_of_items) FROM tblQuiz GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) /* LOWER */
         ELSE (SUM(score) * 100) / SUM(no_of_items)
         END) AS finalGrade,
         (SELECT SUM(no_of_items) FROM tblQuiz GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) as max_quiz_no_of_items,
        (((SELECT percentage FROM tblGradeCritea WHERE critea='Quiz') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblQuiz GROUP BY student_lrn LIMIT 1) 
         THEN (SUM(score) * 100) / (SELECT SUM(no_of_items) FROM tblQuiz GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) /* LOWER */
         ELSE (SUM(score) * 100) / SUM(no_of_items)
         END)) / 100) as equivalent
        FROM tblQuiz WHERE student_lrn=$student_lrn AND subj_code='$subject_code' GROUP BY student_lrn");
       
        if(count($quizResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'quiz_count', 'Quiz', $subject_code);
        }
        else {
          return $quizResult;
        }
     

    }
    public function calculateRecitationRecords($student_lrn, $subject_code) {
        $recitationResult = DB::select("SELECT student_lrn, SUM(points) AS recitation_count,
        (SELECT CONCAT(studentFirstName, ' ', studentLastName) FROM tblstudentinfo WHERE student_lrn=$student_lrn) AS studentFullName,
        (SELECT critea FROM tblGradeCritea WHERE critea='Recitation') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation') AS critea_percentage,
        CASE WHEN SUM(points) >= 10 THEN '100' 
                WHEN (SUM(points) >= 7 AND SUM(points) <= 9) THEN '90' 
                WHEN (SUM(points) >= 4 AND SUM(points) <= 6) THEN '85' 
                WHEN (SUM(points) >= 2 AND SUM(points) <= 3) THEN '80' 
                WHEN SUM(points) = 1 THEN '75' 
                ELSE (SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Recitation')
        END AS finalGrade,
        CASE WHEN SUM(points) >= 10 THEN (100 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                WHEN (SUM(points) >= 7 AND SUM(points) <= 9) THEN (90 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100
                WHEN (SUM(points) >= 4 AND SUM(points) <= 6) THEN (85 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                WHEN (SUM(points) >= 2 AND SUM(points) <= 3) THEN (80 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                WHEN SUM(points) = 1 THEN (75 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                ELSE ((SELECT defaultGrade FROM tblGradeCritea WHERE critea ='Recitation') * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
        END AS equivalent   
        FROM tblRecitation WHERE student_lrn=$student_lrn AND subj_code='$subject_code' GROUP BY student_lrn");

        if($recitationResult === []) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'recitation_count', 'Recitation', $subject_code);
        }
        else {
          return $recitationResult;
        }
     
       
    }

   public function returnNoResult($student_lrn, $critea_count, $critea_name, $subject_code) {

        return [[
          'student_lrn' => $student_lrn,
          'studentFullName' => DB::select("SELECT CONCAT(studentFirstName, ' ', studentLastName) AS studentFullName FROM tblstudentinfo WHERE student_lrn='$student_lrn'")[0]->studentFullName,
          'subject_code' => $subject_code,
          $critea_count => 0,
          'critea_name' => DB::select("SELECT critea FROM tblGradeCritea WHERE critea='$critea_name'")[0]->critea,
          'critea_percentage' => DB::select("SELECT percentage FROM tblGradeCritea WHERE critea='$critea_name'")[0]->percentage,
          'finalGrade' => DB::select("SELECT defaultGrade FROM tblGradeCritea WHERE critea ='$critea_name'")[0]->defaultGrade,
          'equivalent' => (DB::select("SELECT defaultGrade FROM tblGradeCritea WHERE critea ='$critea_name'")[0]->defaultGrade * (DB::select("SELECT percentage FROM tblGradeCritea WHERE critea='$critea_name'")[0]->percentage)) / 100,
      ]];
      

   }
}
