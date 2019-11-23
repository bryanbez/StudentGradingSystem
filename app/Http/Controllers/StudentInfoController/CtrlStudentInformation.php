<?php

namespace App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\StudentInfosModel\StudentInfomationModel as TblStudInfo;
use App\Http\Requests\StoreOrUpdateStudentInfo;

use DB;

class CtrlStudentInformation extends Controller
{
   
    public function index()
    {
        $fetchAllStudent = new TblStudInfo();
        return response()->json($fetchAllStudent->fetchAllStudentRecords());
    }

    public function yearOptions() {

        $fetchYear = new TblStudInfo();
        return $fetchYear->getStudentYear();
    }

    public function fetchStudentsByYearInLRN($year) {

        $fetchYear = new TblStudInfo();
        return $fetchYear->getAllStudentsByYear($year);
    }

    public function searchStudent($searchText) {

        $searchKeyWord = new TblStudInfo();
        return response()->json($searchKeyWord->searchStudentQuery($searchText));
    
    }

    public function create()
    {
        //
    }

    public function store(StoreOrUpdateStudentInfo $request)
    {
        try {
            $validateBa = $request->validated();

            $addStudent = new TblStudInfo;
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
        catch(Exception $e) {
            return $e;
        }
      
    }

    public function show($student_lrn)
    {
        $fetchSpecificStudent = TblStudInfo::
                select(DB::raw('student_lrn, studentLastName, studentFirstName, studentMiddleName, studentAge, studentGender, schoolYear, section, bldg_rmNo'                                                                         ))
                ->where('student_lrn', $student_lrn)
                ->get();
    
        return response()->json($fetchSpecificStudent);
    }

    public function edit($id)
    {
        //
    }

    public function update(StoreOrUpdateStudentInfo $request, $id)
    {

            $validateBa = $request->validated();
          
            $updateStudentRecord = TblStudInfo::where('student_lrn', $id)->update([
                'studentLastName' => $request->txtLastName,
                'studentFirstName' => $request->txtFirstName,
                'studentMiddleName' => $request->txtMiddleName,
                'studentAge' => $request->txtAge,
                'studentGender' => $request->sltGender,
                'schoolYear' => $request->sltYear,
                'section' => $request->txtSection,
                'bldg_rmNo' => $request->txtBldgRmNo
            ]);
                
            return response()->json('Student Record Successfully Updated');
         
    }

    public function destroy($id)
    {
        //
    }
}
