<?php

namespace App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\StudentInfosModel\StudentInfomationModel as TblStudInfo;
use DB;

class CtrlStudentInformation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fetchAllStudent = TblStudInfo::
                select(DB::raw('student_lrn, CONCAT(studentFirstName," ",studentLastName) AS FullName, studentAge, studentGender, schoolYear, section, bldg_rmNo'))
                ->paginate(10);
    
        return response()->json($fetchAllStudent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student_lrn)
    {
        $fetchSpecificStudent = TblStudInfo::
                select(DB::raw('student_lrn, CONCAT(studentFirstName," ",studentLastName) AS FullName, studentAge, studentGender, schoolYear, section, bldg_rmNo'))
                ->where('student_lrn', $student_lrn)
                ->get();
    
        return response()->json($fetchSpecificStudent);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
