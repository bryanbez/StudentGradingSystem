<?php

namespace App\Models\CriteasModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class ManageCriteaModel extends Model
{
    public $table = 'tblgradecritea';
    public $guarded = [];

    public function storeCritea($request) {

        try {
            $storeCritea = new ManageCriteaModel;
            $storeCritea->critea = $request->criteaName;
            $storeCritea->percentage = $request->criteaPercentage;
            $storeCritea->defaultGrade = $request->defaultCriteaGrade;
            $storeCritea->save();
            return 'Critea Information Successfully Inserted';
        } catch (Exception $e) {
            return 'Error inserting critea Information' + $e;
        }
    }

    public function showCriteasRecords() {
        $allCritea = DB::select('select id, critea, percentage, defaultGrade from tblgradecritea');
        $sumAllCriteaPercentage = DB::select('select SUM(percentage) AS total_percentage from tblgradecritea');
        $tojson = [
            'totalPercentage' => $sumAllCriteaPercentage,
            'criteasRecord' => $allCritea,
        ];

        return $tojson;
    }

    public function showCritea($id) {
        return ManageCriteaModel::where('id', $id)->get();
    }

    public function updateCritea($request, $id) {

        try {

            $updateCriteaRecord = ManageCriteaModel::where('id', $id)->update([
                'critea' => $request->textcriteaName,
                'percentage' => $request->textcriteaPercentage,
                'defaultGrade' => $request->defaultCriteaGrade
            ]);
            return response()->json('Critea Record Successfully Updated');    

        } catch (Exception $e) {
            return response()->json('Error updating critea record', + $e);    
        }
     
    }

    public function deleteCritea($id) {
        try {
            $deleteCritea = ManageCriteaModel::where('id', $id)->delete();
            return response()->json('Critea Record Deleted Successfully');   
        } catch(Exception $e) {
            return response()->json('Error deleting critea record', + $e);  
        }
    }


}
