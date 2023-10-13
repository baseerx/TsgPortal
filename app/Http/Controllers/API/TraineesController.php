<?php

namespace App\Http\Controllers\API;

use App\Model\TraineesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TraineesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=DB::table('create_letter')
            ->join('trainees','trainees.letterid','=','create_letter.letterid')
            ->paginate(3);
        return $data;
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

        $validate=$request->validate([
            'name'=>'required|string',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required|email'
        ]);

        TraineesModel::create([
            'letterid'=>$request['tid'],
            'name'=>$request['name'],
            'address'=>$request['address'],
            'phone'=>$request['phone'],
            'email'=>$request['email']
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

           return TraineesModel::find($id);
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

        $validate=$request->validate([
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required|email'
        ]);
        TraineesModel::where('tid', $id)
            ->update([
                'name' => $request['name'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'email' => $request['email']
            ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (strpos($id, 'internal') !== false)
        {
            $val=explode('-',$id);
            $id=$val[0];
            return TraineesModel::destroy($id);
        }
        else
        return TraineesModel::destroy($id);
    }
}
