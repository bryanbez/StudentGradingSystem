<?php

namespace App\Models\StudentInfosModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class StudentInfomationModel extends Model
{
    protected $table = 'tblStudentInfo';
    protected $guarded = [];

    public function fetchAllStudentRecords() {
        return StudentInfomationModel::
        select(DB::raw('student_lrn, studentLastName, studentFirstName, studentMiddleName, studentAge, studentGender, schoolYear, section, bldg_rmNo'))
        ->paginate(10);
    }

    public function getStudentYear() {
        return DB::select("SELECT schoolYear AS Year FROM tblStudentInfo GROUP BY schoolYear"); 
    }
    public function getStudentSection() {
        return DB::select("SELECT section FROM tblStudentInfo GROUP BY section"); 
    }

    public function getAllStudentsByYearAndSection($year, $section) {

        if ($section == 'NULL') {
            return DB::table('tblStudentInfo')
                    ->select(DB::raw('student_lrn, studentLastName, studentFirstName, studentMiddleName, studentAge, studentGender, schoolYear, section, bldg_rmNo'))
                    ->groupBy('student_lrn')
                    ->where('schoolYear', '=', $year)
                    ->paginate(10);
        }
        else {
            return DB::table('tblStudentInfo')
                    ->select(DB::raw('student_lrn, studentLastName, studentFirstName, studentMiddleName, studentAge, studentGender, schoolYear, section, bldg_rmNo'))
                    ->groupBy('student_lrn')
                    ->where('schoolYear', '=', $year)
                    ->where('section', '=', $section)
                    ->paginate(10);
        }
         
    }
    public function searchStudentQuery($keyword) {
    
        return StudentInfomationModel::where('studentLastName', 'LIKE', $keyword.'%')
            ->orWhere('studentFirstName', 'LIKE', $keyword.'%')
            ->orWhere('studentMiddleName', 'LIKE', $keyword.'%')->paginate(10);
     
    }

    public function checkDuplicateStudentLRN($studentLRN) {

        return StudentInfomationModel::select('student_lrn')->where('student_lrn', $studentLRN)->get();
      
    }

    public function store($request) {

            $addStudent = new StudentInfomationModel;
            $addStudent->student_lrn = $request->txtLRN;
            $addStudent->studentFirstName = $request->txtFirstName;
            $addStudent->studentLastName = $request->txtLastName;
            $addStudent->studentMiddleName = $request->txtMiddleName;
            $addStudent->studentAge = $request->txtAge;
            $addStudent->studentGender = $request->sltGender;
            $addStudent->schoolYear = $request->sltYear;
            $addStudent->section = $request->txtSection;
            $addStudent->bldg_rmNo = $request->txtBldgRmNo;
            $addStudent->save();
            
            return response()->json('Student Information Successfully Inserted');
    }
}
