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
        return DB::select("SELECT LEFT(student_lrn, 4) AS Year FROM tblStudentInfo GROUP BY (SELECT LEFT(student_lrn, 4))"); 
    }

    public function getAllStudentsByYear($year) {
          $query = DB::select("SELECT * FROM tblStudentInfo HAVING (SELECT LEFT(student_lrn, 4) as yearEnrolled) = $year");
          return $query;
        // return DB::table('tblStudentInfo')
        //             ->select('*')
        //             ->groupBy('student_lrn')
        //             ->having(DB::table('tblStudentInfo')->selectRaw('LEFT(student_lrn, 4) AS student_lrn'), '=', $year)
        //             ->get();
        // return DB::table('tblStudentInfo')->selectRaw('LEFT(student_lrn, 4) AS yearEnrolled')->get();
        // select * from `tblStudentInfo` group by `student_lrn` having (SELECT LEFT(student_lrn, 4) as student_lrn) = 2014;
        //return DB::table('tblStudentInfo')->selectRaw('LEFT(student_lrn, 4)')->get();
    }
    public function searchStudentQuery($keyword) {
    
        return StudentInfomationModel::where('studentLastName', 'LIKE', $keyword.'%')
            ->orWhere('studentFirstName', 'LIKE', $keyword.'%')
            ->orWhere('studentMiddleName', 'LIKE', $keyword.'%')->paginate(10);
     
    }
}
