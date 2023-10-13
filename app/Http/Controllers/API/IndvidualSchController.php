<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\AddCourse;
use App\Model\IndividualModel;
use App\Model\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndvidualSchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursetypeid=DB::table('add_courses')->where('status','1')->value('coursetype_id');
        $data=DB::table('indschedual')
            ->join('trainees','trainees.tid','=','indschedual.traineetype')
            ->join('course_types','course_types.coursetype_id','=','indschedual.trainingtype')
            ->where('course_types.coursetype_id',$coursetypeid)
            ->paginate(60);
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
            'traineetype'=>'required',
            'description'=>'required',
            'file'=>'required',
            'trainingtype'=>'required'
        ]);
        $orignalName=explode('.',$request->file->getClientOriginalName());
        $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('indschedual'), $fileNewName);

        return IndividualModel::create([
            'traineetype'=>$request['traineetype'],
            'description'=>$request['description'],
            'file'=>$fileNewName,
            'trainingtype'=>$request['trainingtype']
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
        if (strpos($id, 'ind') !== false) {
            $email=session('useremail')[0].'@'.session('useremail')[1];
            $tid=DB::table('create_letter')
            ->join('add_courses', 'add_courses.cid', 'create_letter.course')
            ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $email)->where('add_courses.status','1')->value('trainees.tid');
            $trainingData = DB::table('indschedual')->join('course_types','course_types.coursetype_id','=','indschedual.trainingtype')->where('indschedual.traineetype',$tid)->get();
            return $trainingData;
        } else {
            return IndividualModel::find($id);
        }
        
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
        $toSave=IndividualModel::find($id);
        if (!strcmp($request['file'],$toSave['file']))
        {
            $toSave=IndividualModel::find($id);
            $toSave->traineetype=$request['traineetype'];
            $toSave->description=$request['description'];
            $toSave->file=$request['file'];
            $toSave->trainingtype=$request['trainingtype'];
            $toSave->save();
        }
        else{
            $request->validate([
                'traineetype'=>'required',
                'description'=>'required',
                'filetype'=>'required',
                'file'=>'required',
                'trainingtype'=>'required',
            ]);
            $toSave=IndividualModel::find($id);
            $fileStr=strval($toSave['file']);

            unlink(public_path('indschedual/'.$fileStr));
            $toSave->traineetype=$request['traineetype'];
            $toSave->description=$request['description'];
            $orignalName=explode('.',$request->file->getClientOriginalName());
            $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('indschedual'), $fileNewName);
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
      return IndividualModel::destroy($id);
    }
}
