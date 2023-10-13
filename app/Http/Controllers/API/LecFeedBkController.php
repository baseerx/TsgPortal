<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\AddCourse;
use App\Model\FeedBack;
use App\Model\LectureFeed;
use App\Model\TraineesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LecFeedBkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty(session('external')))
        $email = session('useremail');
        else
        $email = session('useremail')[0] . '@' . session('useremail')[1];

        $letterId = TraineesModel::where('email', $email)->value('letterid');
        $currentCourse = DB::table('create_letter')
            ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
            ->where('create_letter.letterid', $letterId)->value('course');
        $vals = explode('-', $request['feedback']);
        $check = LectureFeed::where('question', $vals[1])->where('userid', session('userid'))->value('lecfid');
        $courseDet = AddCourse::find($currentCourse);
        if (!empty($check)) {
            $toSave = LectureFeed::find($check);
            $toSave->category = $vals[2];
            $toSave->lecture = $request['pid'];
            $toSave->course = $currentCourse;
            $toSave->question = $vals[1];
            $toSave->answer = $vals[0];
            $toSave->userid = session('userid');
            $toSave->save();
        } else {
            LectureFeed::create([
                'category' => $vals[2],
                'lecture' => $request['pid'],
                'course' => $currentCourse,
                'question' => $vals[1],
                'answer' => $vals[0],
                'userid' => session('userid')
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = session('userid');
        $checkId = LectureFeed::where('userid', $userId)->where('lecture',$id)->exists();
        return response()->json($checkId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
