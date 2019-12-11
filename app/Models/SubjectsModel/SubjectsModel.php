<?php

namespace App\Models\SubjectsModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubjectsModel extends Model
{
    protected $table = 'tblsubjects';
    protected $guarded = [];

    public function store($request) {

        try {

            $addSubject = new SubjectsModel;
            $addSubject->subj_code = $request->txtSubjCode;
            $addSubject->subj_for_yr = $request->sltLrnYear;
            $addSubject->subj_name = $request->txtSubjName;
            $addSubject->subj_description = $request->txtSubjDesc;
            $addSubject->save();
    
            return response()->json('Subject Information Successfully Inserted');

        } catch (Exception $e) {
            return response()->json('Error inserting subject record' + $e);
        }

    
    }

    public function fetchSubjects() {

       return SubjectsModel::paginate(10);

    }

    public function updateSubject($request, $id) {
        try {
            $updateSubject = SubjectsModel::where('subj_code', $id)->update([
                'subj_for_yr' => $request->sltLrnYear,
                'subj_name' => $request->txtSubjName,
                'subj_description' => $request->txtSubjDesc,
            ]);  
            return response()->json('Subject Record Successfully Updated');
        } catch(Exception $e) {
            return response()->json('Error upating subject record' + $e);
        }

      
    }

    public function showSubjectRecord($id) {
        return SubjectsModel::where('subj_code', $id)->get();
    }

    public function displaySubjectByYear($year) {
        return SubjectsModel::where('subj_for_yr', $year)->get();
    }

    public function deleteSubject($id) {
        SubjectsModel::where('subj_code', $id)->delete();
        return response()->json('Subject Record Successfully Deleted');
    }
}
