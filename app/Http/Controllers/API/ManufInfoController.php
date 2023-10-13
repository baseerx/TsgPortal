<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\ManufactureInfo;
use Illuminate\Http\Request;

class ManufInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ManufactureInfo::paginate(10);
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
            'mname'=>'required',
            'description'=>'required',
        ]);
        return ManufactureInfo::create([
            'mname'=>$request['mname'],
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
        if (strpos($id,'all')!==false)
        {
            return ManufactureInfo::all();
        }
        else
        return ManufactureInfo::find($id);
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
            'mname'=>'required',
            'description'=>'required',
        ]);
        $toSave=ManufactureInfo::find($id);
        $toSave->mname=$request['mname'];
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
        return ManufactureInfo::destroy($id);
    }
}
