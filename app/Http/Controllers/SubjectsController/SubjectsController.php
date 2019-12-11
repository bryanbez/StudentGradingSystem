<?php

namespace App\Http\Controllers\SubjectsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubjectsModel\SubjectsModel;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addSubject = new SubjectsModel;
        return response()->json($addSubject->fetchSubjects());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateRequest = $request->validate([
            'txtSubjCode' => 'required|max:10',
            'sltLrnYear' => 'required',
            'txtSubjName' => 'required',
            'txtSubjDesc' => 'required',
        ]);

        $addSubject = new SubjectsModel;
        return response()->json($addSubject->store($request));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showSubject = new SubjectsModel;
        return response()->json($showSubject->showSubjectRecord($id));
    }

    public function showSubjectsPerYear($year) {
        $showSubjectPerYear = new SubjectsModel;
        return response()->json($showSubjectPerYear->displaySubjectByYear($year));
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
        $validateRequest = $request->validate([
            'sltLrnYear' => 'required',
            'txtSubjName' => 'required',
            'txtSubjDesc' => 'required',
        ]);
     
        $updateSubject = new SubjectsModel;
        return response()->json($updateSubject->updateSubject($request, $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteSubject = new SubjectsModel;
        return response()->json($deleteSubject->deleteSubject($id));
    }
}
