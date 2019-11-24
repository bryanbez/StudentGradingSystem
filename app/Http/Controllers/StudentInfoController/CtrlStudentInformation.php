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

    public function sectionOptions() {

        $fetchSection = new TblStudInfo();
        return $fetchSection->getStudentSection();
    }


    public function fetchStudentsByYearInLRN($year, $section) {

        $fetchYear = new TblStudInfo();
        return $fetchYear->getAllStudentsByYearAndSection($year, $section);
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
        
         $validateBa = $request->validated();
         $insertRecord = new TblStudInfo();

         if($insertRecord->checkDuplicateStudentLRN($request->txtLRN)->isEmpty()){
            return $insertRecord->store($request);
         }
         else {
            return response()->json('Duplicate Student LRN');
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
