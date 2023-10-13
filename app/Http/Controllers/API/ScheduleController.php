<?php

namespace App\Http\Controllers\API;

use App\Model\CourseSchedule;
use App\Model\LetterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ScheduleController extends Controller
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
        $data=DB::table('course_schedules')
            ->join('instructors','instructors.ins_id','=','course_schedules.instructor')
            ->join('add_courses','add_courses.cid','=','course_schedules.course')
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

        $request->validate([
            'course'=>'required',
            'instructor'=>'required',
            'sdate'=>'required',
            'edate'=>'required',

        ]);

        $date1=explode('T',$request['sdate']);
        $date2=explode('T',$request['edate']);
        CourseSchedule::create([
            'course'=>$request['course'],
            'ctitle'=>$request['ctitle'],
            'instructor'=>$request['instructor'],
            'sdate'=>$date1[0],
            'edate'=>$date2[0]
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

        if (!strcmp($id,'getcourse'))
        {
            return DB::table('add_courses')->where('status',1)->get();
        }
        else if (Str::contains($id,'_courseId'))
        {
            $courseId=explode('_',$id);
            return CourseSchedule::where('course',$courseId[0])->get();
        }
        else if (!strcmp($id,'getletterno'))
        {
            return DB::table('create_letter')->select('lno')->distinct()->get();
        }
        else if (strpos($id, 'totalT-') !== false)
        {
            $letrno=explode('-',$id);
            $data=DB::table('course_schedules')
                ->join('create_letter','create_letter.lno','=','course_schedules.lno')
                ->where('course_schedules.lno','=',$letrno[1])
                ->get();
            return $data;
        }
        elseif(!strcmp($id,'definelib'))
        {
            return CourseSchedule::all();
        }
        else
        {
            return CourseSchedule::find($id);
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
        $tosave=CourseSchedule::find($id);
        $request->validate([
            'course'=>'required',
            'instructor'=>'required',
            'sdate'=>'required',
            'edate'=>'required',
        ]);
        if (strpos($request['sdate'], 'T') !== false)
        {
            $s=explode('T',$request['sdate']);
            $request['sdate']=$s[0];
        }
        if (strpos($request['edate'], 'T') !== false)
        {
            $d=explode('T',$request['edate']);
            $request['edate']=$d[0];
        }

        $tosave->course=$request['course'];
        $tosave->ctitle=$request['ctitle'];
        $tosave->instructor=$request['instructor'];
        $tosave->sdate=$request['sdate'];
        $tosave->edate=$request['edate'];
        $tosave->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $courseId=CourseSchedule::where('sch_id',$id)->value('course');
         $letterid=LetterModel::where('course',$courseId)->exists();
         if (empty($letterid))
             CourseSchedule::destroy($id);
         else
             abort(404,"Revelant data exists therefore it can't be deleted..");


    }
}
