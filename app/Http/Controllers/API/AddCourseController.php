<?php

namespace App\Http\Controllers\API;
use App\Model\AddCourse;
use App\Model\CourseArea;
use App\Model\CourseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = DB::table('add_courses')
            ->join('course_areas', 'add_courses.carea_id', '=', 'course_areas.carea_id')
            ->join('course_types', 'add_courses.coursetype_id', '=', 'course_types.coursetype_id')
            ->select('add_courses.cid','add_courses.cdesc', 'add_courses.ccode', 'course_areas.carea_desc', 'course_types.coursetype_desc')
            ->paginate(5);
         return $notices;
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
           'courseDesc'=>'required',
           'courseCode'=>'required',
        ]);
        AddCourse::create([
           'cdesc'=>$request->input('courseDesc'),
           'ccode'=>$request->input('courseCode'),
           'carea_id'=>$request->input('areaFor'),
           'coursetype_id'=>$request->input('courseFor'),
           'status'=>$request->input('status'),
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
               if (strpos($id,'definelib-')!==false)
               {
                  $trainingtype=explode('-',$id);
                  $data=DB::table('add_courses')->where('coursetype_id',$trainingtype[1])->get();
                  return $data;
               } elseif (strpos($id, 'definelib*') !== false)
               {
                   $courseId=explode('*',$id);
                   $check=AddCourse::where('coursetype_id',$courseId[1])->get();
                   return $check;
               }elseif(strpos($id,'definelib')!==false)
               {
                  return AddCourse::where('status',1)->get();
               }
               else
               {
                   $check=AddCourse::find($id);
                   return $check;
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
        $toSave=AddCourse::find($id);
        $toSave->cdesc=$request['addcourse'];
        $toSave->ccode=$request['coursecode'];
        $toSave->carea_id=$request['aid'];
        $toSave->coursetype_id=$request['cid'];
        $toSave->status=$request['status'];
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
        $rec=AddCourse::where('status',1)->where('cid',$id)->exists();
//        $acheck=CourseArea::find($rec['carea_id'])->exists();
//        $ccheck=CourseType::find($rec['coursetype_id'])->exists();

        if (empty($rec))
        {
            AddCourse::destroy($id);
        }
        else
        abort(404,"There is something wrong in data deletion..");
    }
}
