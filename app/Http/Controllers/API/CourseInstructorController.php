<?php

namespace App\Http\Controllers\API;

use App\Model\AddCourse;
use App\Model\CourseInstructor;
use App\Model\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseInstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('course_instructors')->join('add_courses','course_instructors.course_id','=','add_courses.cid')
            ->join('instructors','course_instructors.ins_id','=','instructors.ins_id')->paginate(4);
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
            'course_id'=>'required|numeric',
            'ins_id'=>'required|numeric',
        ]);

        CourseInstructor::create([
           'course_id'=>$request['course_id'],
           'ins_id'=>$request['ins_id'],
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
        if (!strcmp($id,'cinstructor'))
        {
            return AddCourse::all();
        }
        elseif (!strcmp($id,'instructor'))
        {
            return Instructor::all();
        }
        else
            return CourseInstructor::find($id);
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
        Log::info($request->all());
        Log::info($id);
        $toSave=CourseInstructor::find($id);
        $validate=$request->validate([
            'course_id'=>'required|numeric',
            'ins_id'=>'required|numeric',
        ]);


        $toSave->course_id=$request['course_id'];
        $toSave->ins_id=$request['ins_id'];
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
        $cicheck=CourseInstructor::find($id);
        $instructCheck=Instructor::find($cicheck['ins_id'])->exists();
        $CourseCheck=AddCourse::find($cicheck['course_id'])->exists();
        if ($instructCheck || $CourseCheck)
        {
            abort(404,'Data exists in parent tables..');
        }
        else
            return CourseInstructor::destroy($id);
    }
}
