<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Examination;
use App\Model\LetterModel;
use App\Model\ResultReport;
use App\Model\SubmitResult;
use App\Model\TraineesModel;
use App\Model\WritePaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubmitResultController extends Controller
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
//        Data is coming successfully..
        if (!empty(session('external')))
        $userEmail = session('useremail');
        else
        $userEmail = session('useremail')[0] . '@' . session('useremail')[1];

        $userName = session('username');

        $letterId=DB::table('trainees')
            ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
            ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
            ->where('add_courses.status', '=', '1')
            ->where('trainees.email', '=', $userEmail)
            ->value('trainees.letterid');

        $currentCourse = DB::table('create_letter')
            ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
            ->where('create_letter.letterid', $letterId)->where('status','1')->value('course');

        $marksPerMcqs = Examination::where('course', $currentCourse)->where('exam_status',1)->value('marks');
        $exam_id = Examination::where('course', $currentCourse)->where('exam_status',1)->value('exam_id');

        $mcqsCount = WritePaper::where('course', $currentCourse)->where('exam_id',$exam_id)->count();

        $hrisId = session('userid');
        $result = ResultReport::where('userid', '=', $hrisId)->where('course',$currentCourse)->where('exam_id',$exam_id)->where('flag', '=', 1)->count();
        $marksAchieved = $result * $marksPerMcqs;
        $totalMarks = $mcqsCount * $marksPerMcqs;
        $percentage = ($marksAchieved / $totalMarks) * 100;
        $percentage=round($percentage,2);
//        compute percentage
        $ifExists=SubmitResult::where('rollno',$hrisId)->where('exam_id',$exam_id)->value('subr_id');

        if (!empty($ifExists))
        {

            $toSave=SubmitResult::find($ifExists);
            $toSave->email=$userEmail;
            $toSave->name=$userName;
            $toSave->rollno=$hrisId;
            $toSave->result=$marksAchieved;
            $toSave->percentage=$percentage;
            $toSave->course=$currentCourse;
            $toSave->exam_id=$exam_id;
            $toSave->save();
        }
       else
       {
           SubmitResult::create([
               'email' => $userEmail,
               'name' => $userName,
               'rollno' => $hrisId,
               'result' => $marksAchieved,
               'percentage' => $percentage,
               'course' => $currentCourse,
               'exam_id' => $exam_id
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
        //
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
