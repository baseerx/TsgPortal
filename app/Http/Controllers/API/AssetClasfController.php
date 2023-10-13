<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\AssetClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetClasfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AssetClassification::paginate(10);
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
        $validateData=$request->validate([
            'assetcls'=>'required',
            'description'=>'required',
        ]);
        return AssetClassification::create([
            'assetcls'=>$request['assetcls'],
            'description'=>$request['description'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (strpos($id,'forMainScreen')!==false)
        {
            $data=DB::table('asset_classifications')->get();
            return $data;
        }
        else
        return AssetClassification::find($id);
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
        $validateData=$request->validate([
            'assetcls'=>'required',
            'description'=>'required',
        ]);
        $toSave=AssetClassification::find($id);
        $toSave->assetcls=$request['assetcls'];
        $toSave->description=$request['description'];
        $toSave->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return AssetClassification::destroy($id);
    }
}
