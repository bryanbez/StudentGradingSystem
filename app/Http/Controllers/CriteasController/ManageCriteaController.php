<?php

namespace App\Http\Controllers\CriteasController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CriteasModel\ManageCriteaModel;

class ManageCriteaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fetchCritea = new ManageCriteaModel;
        return response()->json($fetchCritea->showCriteasRecords());
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
        $validateRequest = $request->validate([
            'criteaName' => 'required',
            'criteaPercentage' => 'required'
        ]);

        $addCritea = new ManageCriteaModel;
        return response()->json($addCritea->storeCritea($request));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showCritea = new ManageCriteaModel;
        return response()->json($showCritea->showCritea($id));
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
            'textcriteaName' => 'required',
            'textcriteaPercentage' => 'required'
        ]);

        $updateCritea = new ManageCriteaModel;
        return response()->json($updateCritea->updateCritea($request, $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCritea = new ManageCriteaModel;
        return response()->json($deleteCritea->deleteCritea($id));
    }
}
