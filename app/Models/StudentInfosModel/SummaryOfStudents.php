<?php

namespace App\Models\StudentInfosModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class SummaryOfStudents extends Model
{
    public function getAllStudentsCount() {

        return DB::select('SELECT COUNT(*) AS totalStudents FROM tblStudentInfo');
    }

    public function getAllMaleStudentsCount() {

        return DB::select("SELECT COUNT(*) AS totalMaleStudents FROM tblStudentInfo WHERE studentGender='male'");
    }

    public function getAllFemaleStudentsCount() {

        return DB::select("SELECT COUNT(*) AS totalFemaleStudents FROM tblStudentInfo WHERE studentGender='female'");
    }

    public function getAllFirstYearStudentsCount() {

        return DB::select("SELECT COUNT(*) AS totalFirstYearStudents FROM tblStudentInfo WHERE schoolYear='1'");
    }

    public function getAllSecondYearStudentsCount() {
        
        return DB::select("SELECT COUNT(*) AS totalSecondYearStudents FROM tblStudentInfo WHERE schoolYear='2'");
    }

    public function getAllThirdYearStudentsCount() {
        
        return DB::select("SELECT COUNT(*) AS totalThirdYearStudents FROM tblStudentInfo WHERE schoolYear='3'");
    }

    public function getAllFourthYearStudentsCount() {
        
        return DB::select("SELECT COUNT(*) AS totalFourthYearStudents FROM tblStudentInfo WHERE schoolYear='4'");
    }


}
