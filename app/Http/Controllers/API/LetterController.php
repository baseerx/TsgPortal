<?php

namespace App\Http\Controllers\API;

use App\Model\LetterModel;
use App\Model\TraineesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LetterController extends Controller
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
            ->join('instructors','instructors.ins_id','=','create_letter.instructor')
            ->join('add_courses','add_courses.cid','=','create_letter.course')
            ->join('course_schedules','course_schedules.course','=','create_letter.course')
            ->where('add_courses.status','1')
            ->paginate(4);
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
            'letterTitle'=>'required|string',
            'letterNo'=>'required',
            'letterDate'=>'required|date',
            'course'=>'required',
            'instructor'=>'required',
            'sdate'=>'required|date',
            'edate'=>'required|date',
            'checkParticipent'=>'required',
        ]);
        $date1=explode('T',$request->input('sdate'));
        $date2=explode('T',$request->input('edate'));
        $date3=explode('T',$request->input('letterDate'));

        LetterModel::create([
            'ltitle'=>$request['letterTitle'],
            'lno'=>$request['letterNo'],
            'ldate'=>$date3[0],
            'course'=>$request['course'],
            'ctitle'=>$request['ctitle'],
            'instructor'=>$request['instructor'],
            'sdate'=>$date1[0],
            'edate'=>$date2[0],
            'checkparticipent'=>$request['checkParticipent']
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
        return DB::select("select letterid,ltitle as letterTitle,lno as letterNo,ldate as letterDate,course,ctitle,instructor,sdate,edate,checkparticipent as checkParticipent from create_letter where letterid='$id'");
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $letterCheck=TraineesModel::where('letterid',$id)->exists();
        if (empty($letterCheck))
            LetterModel::destroy($id);
        else
            abort(404,"Record can't be deleted,as revelant data exists..");
//        LetterModel::destroy($id);
    }
}
