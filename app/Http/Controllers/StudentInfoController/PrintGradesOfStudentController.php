<?php

namespace App\Http\Controllers\StudentInfoController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentInfosModel\PrintGradesOfStudentModel as TblStudInfoModel;

class PrintGradesOfStudentController extends Controller
{
    public function index($year, $section) {

        $getAll = new TblStudInfoModel();
        return response()->json($getAll->getAllStudentGradesBasedOnYearAndSection($year, $section));
        
    }
}
