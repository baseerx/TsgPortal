<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\LeasingCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeasingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LeasingCompany::paginate(10);
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
            'name'=>'required',
            'description'=>'required',
        ]);
        return LeasingCompany::create([
            'name'=>$request['name'],
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
            $data=DB::table('leasingcomps')->get();
            return $data;
        }
        else
        return LeasingCompany::find($id);
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
            'name'=>'required',
            'description'=>'required',
        ]);
        $toSave=LeasingCompany::find($id);
        $toSave->name=$request['name'];
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
        return LeasingCompany::destroy($id);
    }
}
