<?php

namespace App\Models\CriteasModel;

use Illuminate\Database\Eloquent\Model;
use DB;


class GradeCriteaModel extends Model
{
    protected $table = 'tblGradeCritea';
    protected $guarded = [];

    public function calculateExamRecords($student_lrn) {

        $examResult = DB::select(
        "SELECT student_lrn, COUNT(student_lrn) AS exam_count,
        (SELECT critea FROM tblGradeCritea WHERE critea='Exam') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Exam') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS exam_count FROM tblExam GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_exam_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) 
         THEN ((((SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) - (SELECT COUNT(student_lrn) FROM tblExam WHERE student_lrn=$student_lrn)) 
        * 65) + (((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn))) 
        / (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) /* LOWER */
         ELSE ((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn)
         END) AS finalGrade,
        (((SELECT percentage FROM tblGradeCritea WHERE critea='Exam') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) 
         THEN ((((SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) - (SELECT COUNT(student_lrn) FROM tblExam WHERE student_lrn=$student_lrn)) 
        * 65) + (((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn))) 
        / (SELECT COUNT(student_lrn) FROM tblExam GROUP BY student_lrn LIMIT 1) /* LOWER */
         ELSE ((SELECT SUM(score) FROM tblExam WHERE student_lrn=$student_lrn) * 100) / (SELECT SUM(no_of_items) FROM tblExam WHERE student_lrn=$student_lrn)
         END)) / 100) as equivalent    
        FROM tblExam WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($examResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'exam_count', 'Exam');
        }
        else {
            return $examResult;
        }

    }
    public function calculateAssignmentRecords($student_lrn) {

        $assignmentResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS assignment_count, 
        (SELECT critea FROM tblGradeCritea WHERE critea='Assignment') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Assignment') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_assignment_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblAssignment GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblAssignment WHERE student_lrn=$student_lrn))
          * 65 + (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment WHERE student_lrn=$student_lrn)
         END) AS finalGrade,
         (((SELECT percentage FROM tblGradeCritea WHERE critea='Assignment') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblAssignment GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblAssignment WHERE student_lrn=$student_lrn))
          * 65 + (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblAssignment WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS assignment_count FROM tblAssignment WHERE student_lrn=$student_lrn)
         END)) / 100) as equivalent
        FROM tblAssignment WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($assignmentResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'assignment_count', 'Assignment');
        }
        else {
          return $assignmentResult;
        }

    }
    public function calculateProjectRecords($student_lrn) {

        $projectResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS project_count, 
        (SELECT critea FROM tblGradeCritea WHERE critea='Project') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Project') AS critea_percentage,
        (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) AS max_project_number,
        (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblProjects GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblProjects WHERE student_lrn=$student_lrn))
          * 65 + (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS project_count FROM tblProjects WHERE student_lrn=$student_lrn)
         END) AS finalGrade,
        (((SELECT percentage FROM tblGradeCritea WHERE critea='Project') * (CASE WHEN COUNT(student_lrn) < (SELECT COUNT(student_lrn) FROM tblProjects GROUP BY student_lrn LIMIT 1) 
         THEN (((SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1) 
            - (SELECT COUNT(student_lrn) FROM tblProjects WHERE student_lrn=$student_lrn))
          * 65 + (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn)) 
          /  (SELECT COUNT(student_lrn) AS project_count FROM tblProjects GROUP BY student_lrn ORDER BY COUNT(student_lrn) DESC LIMIT 1)
        /* LOWER */
         ELSE (SELECT SUM(grade) FROM tblProjects WHERE student_lrn=$student_lrn) / (SELECT COUNT(student_lrn) AS project_count FROM tblProjects WHERE student_lrn=$student_lrn)
         END)) / 100) as equivalent
        FROM tblProjects WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($projectResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'project_count', 'Project');
        }
        else {
          return $projectResult;
        }

      
    }
    public function calculateQuizRecords($student_lrn) {

        $quizResult = DB::select("SELECT student_lrn, COUNT(student_lrn) AS quiz_count, 
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
        FROM tblQuiz WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($quizResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'quiz_count', 'Quiz');
        }
        else {
          return $quizResult;
        }

    }
    public function calculateRecitationRecords($student_lrn) {
        $recitationResult = DB::select("SELECT student_lrn, SUM(points) AS recitation_count,
        (SELECT critea FROM tblGradeCritea WHERE critea='Recitation') AS critea_name,
        (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation') AS critea_percentage,
        CASE WHEN SUM(points) >= 10 THEN '100' 
                WHEN (SUM(points) >= 7 AND SUM(points) <= 9) THEN '90' 
                WHEN (SUM(points) >= 4 AND SUM(points) <= 6) THEN '85' 
                WHEN (SUM(points) >= 2 AND SUM(points) <= 3) THEN '80' 
                WHEN SUM(points) = 1 THEN '75' 
                ELSE '65' 
        END AS finalGrade,
        CASE WHEN SUM(points) >= 10 THEN (100 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                WHEN (SUM(points) >= 7 AND SUM(points) <= 9) THEN (90 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100
                WHEN (SUM(points) >= 4 AND SUM(points) <= 6) THEN (85 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                WHEN (SUM(points) >= 2 AND SUM(points) <= 3) THEN (80 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                WHEN SUM(points) = 1 THEN (75 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
                ELSE (65 * (SELECT percentage FROM tblGradeCritea WHERE critea='Recitation')) / 100 
        END AS equivalent   
        FROM tblRecitation WHERE student_lrn=$student_lrn GROUP BY student_lrn");

        if(count($recitationResult) === 0) {
          return GradeCriteaModel::returnNoResult($student_lrn, 'recitation_count', 'Recitation');
        }
        else {
          return $recitationResult;
        }

       
    }

    public function returnNoResult($student_lrn, $critea_count, $critea_name) {

      return [[
        'student_lrn' => $student_lrn,
        $critea_count => 0,
        'critea_name' => DB::select("SELECT critea FROM tblGradeCritea WHERE critea='$critea_name'")[0]->critea,
        'critea_percentage' => DB::select("SELECT percentage FROM tblGradeCritea WHERE critea='$critea_name'")[0]->percentage,
        'finalGrade' => 65,
        'equivalent' => (65 * (DB::select("SELECT percentage FROM tblGradeCritea WHERE critea='$critea_name'")[0]->percentage)) / 100,
    ]];

    }
}
