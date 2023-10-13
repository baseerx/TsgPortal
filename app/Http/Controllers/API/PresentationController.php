<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainingData=DB::table('presentations')
            ->join('course_types','presentations.trainingtype','=','course_types.coursetype_id')
            ->join('trainees','presentations.user','=','trainees.tid')
            ->paginate(15);
        return $trainingData;
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
            'user'=>'required',
            'description'=>'required',
            'filetype'=>'required',
            'file'=>'required',
            'trainingtype'=>'required'
        ]);
        $orignalName=explode('.',$request->file->getClientOriginalName());
        $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('presentation_files'), $fileNewName);
        $cid=DB::table('add_courses')->where('coursetype_id',$request['trainingtype'])->where('status',1)->value('cid');
        return Presentation::create([
            'user'=>$request['user'],
            'description'=>$request['description'],
            'filetype'=>$request['filetype'],
            'file'=>$fileNewName,
            'trainingtype'=>$request['trainingtype'],
            'course'=>$cid
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
        return Presentation::find($id);
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
        $toSave=Presentation::find($id);
        if (!strcmp($request['file'],$toSave['file']))
        {
            $toSave=Presentation::find($id);
            $toSave->user=$request['user'];
            $toSave->description=$request['description'];
            $toSave->filetype=$request['filetype'];
            $toSave->file=$request['file'];
            $toSave->trainingtype=$request['trainingtype'];
            $toSave->save();
        }
        else{
            $request->validate([
                'user'=>'required',
                'description'=>'required',
                'filetype'=>'required',
                'file'=>'required',
                'trainingtype'=>'required',
            ]);
            $toSave=Presentation::find($id);
            $fileStr=strval($toSave['file']);
            unlink(public_path('presentation_files/'.$fileStr));
            $toSave->user=$request['user'];
            $toSave->description=$request['description'];
            $toSave->filetype=$request['filetype'];
            $orignalName=explode('.',$request->file->getClientOriginalName());
            $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('presentation_files'), $fileNewName);
            $toSave->file=$fileNewName;
            $toSave->trainingtype=$request['trainingtype'];
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
        return Presentation::destroy($id);
    }
}
