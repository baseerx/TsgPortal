<?php

namespace App\Http\Controllers\API;

use App\Model\AddCourse;
use App\Model\CourseSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CourseType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CourseType::paginate(4);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'coursetype' => 'required'
        ]);
        $courseType = $request->input('coursetype');
        CourseType::create([
            'coursetype_desc' => $courseType,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Str::contains($id,'_course'))
        {
            $courseId=explode('_',$id);
            $courseType = DB::table('add_courses')
                ->join('course_types', 'add_courses.coursetype_id', '=', 'course_types.coursetype_id')
                ->where('add_courses.cid',$courseId[0])
                ->get();
//            Log::info($courseType);
            return $courseType;
        }
        else
        return CourseType::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'coursetype' => 'bail|required|alpha'
        ]);
        $updatedVal = $request->input('coursetype');
        $save = CourseType::find($id);
        $save->coursetype_desc = $updatedVal;
        $save->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check=AddCourse::where('coursetype_id',$id)->exists();
        if (empty($check))
        {
            return CourseType::destroy($id);
        }
        else
            abort(404,'Record exists in another table');

    }
}
