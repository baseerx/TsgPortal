<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Model\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Assignment::paginate(10);
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
        $request->validate([
            'description'=>'required',
            'filetype'=>'required',
            'file'=>'required',
            'trainingtype'=>'required',
            'course'=>'required'
        ]);

        $orignalName=explode('.',$request->file->getClientOriginalName());
        $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('presentation_files'), $fileNewName);

        return Assignment::create([
            'description'=>$request['description'],
            'filetype'=>$request['filetype'],
            'file'=>$fileNewName,
            'trainingtype'=>$request['trainingtype'],
            'course'=>$request['course']
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
      return Assignment::find($id);
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
           $existingFile=$this->show($id);
        if (!strcmp($request['file'],$existingFile['file']))
        {
            $toSave=Assignment::find($id);
            $toSave->description=$request['description'];
            $toSave->filetype=$request['filetype'];
            $toSave->file=$request['file'];
            $toSave->course=$request['course'];
            $toSave->save();
        }
        else{
            $request->validate([
                'description'=>'required',
                'filetype'=>'required',
                'file'=>'required',
                'course'=>'required'
            ]);
            $toSave=Assignment::find($id);
            $fileStr=strval($toSave['file']);
            unlink(public_path('presentation_files/'.$fileStr));
            $toSave->description=$request['description'];
            $toSave->filetype=$request['filetype'];
            $toSave->course=$request['course'];
            $orignalName=explode('.',$request->file->getClientOriginalName());
            $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('presentation_files'), $fileNewName);
            $toSave->file=$fileNewName;
            $toSave->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Assignment::destroy($id);
    }
}
