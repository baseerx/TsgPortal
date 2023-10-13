<?php

namespace App\Http\Controllers\API;

use App\Model\AddCourse;
use App\Model\Examination;
use App\Model\Instructor;
use App\Model\LetterModel;
use App\Model\SubmitResult;
use App\Model\TraineesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\Cloner\Data;

class DisplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!empty(session('external'))) {
            $userEmail = session('useremail');
        } else {
            $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
        }
        $courseId = DB::table('create_letter')
            ->join('trainees', 'create_letter.letterid', '=', 'trainees.letterid')
            ->where('trainees.email', $userEmail)->pluck('create_letter.course');
        $data = DB::table('course_schedules')
            ->join('add_courses', 'add_courses.cid', '=', 'course_schedules.course')
            ->whereIn('add_courses.cid', $courseId)
            ->get();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $traineEmail = explode('-', $id);
        if (strpos($id, 'onLogin') !== false) {
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }
            $trainee = DB::table('trainees')
                ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                ->where('add_courses.status', '=', '1')
                ->where('trainees.email', '=', $userEmail)
                ->get();
            return $trainee;
        } elseif (strpos($id, 'onLogannouncement-') !== false) {
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }
            $traineeData = TraineesModel::where('email', $userEmail)->max('letterid');
            $letterid = $traineeData;
            $courseid = DB::table('create_letter')->where('letterid', $letterid)->max('course');
            if (!empty($traineeData)) {
                $coursetype = DB::table('add_courses')->where('cid', $courseid)->where('status', '1')->value('coursetype_id');
                $trainingData = DB::table('assignments')
                    ->join('course_types', 'course_types.coursetype_id', '=', 'assignments.trainingtype')
                    ->where('assignments.trainingtype', $coursetype)
                    ->where('assignments.course', $courseid)
                    ->get();
                return $trainingData;
            }
        } elseif (strpos($id, 'trainee-') !== false) {
            $trainee = DB::table('trainees')
                ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                ->where('trainees.email', '=', $traineEmail[1])
                ->get();
            return $trainee;
        } else if (strpos($id, 'content-') !== false) {
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }
            $courseId = DB::table('create_letter')
                ->join('trainees', 'create_letter.letterid', '=', 'trainees.letterid')
                ->where('trainees.email', $userEmail)->pluck('create_letter.course');

            $courseTypeId = AddCourse::whereIn('cid', $courseId)->where('status', '1')->first();

            $trainingData = DB::table('presentations')
                ->join('course_types', 'presentations.trainingtype', '=', 'course_types.coursetype_id')
                ->where('course_types.coursetype_id', '=', $courseTypeId->coursetype_id)
                ->where('presentations.course', '=', $courseTypeId->cid)
                ->where('presentations.filetype', '=', 'lecture')
                ->get();
            return $trainingData;
        } else if (strpos($id, 'instructor-') !== false) {
            $traineeData = TraineesModel::where('email', $traineEmail[1])->first();
            $Data = DB::table('indschedual')
                ->join('trainees', 'trainees.tid', '=', 'indschedual.traineetype')
                ->join('course_types', 'course_types.coursetype_id', '=', 'indschedual.trainingtype')
                ->where('indschedual.traineetype', '=', $traineeData['tid'])
                ->get();
            return $Data;
        } else if (strpos($id, 'specificTrainee-') !== false) {

//            $traineeData = TraineesModel::where('email', $traineEmail[1])->first();
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }
            $course = DB::table('create_letter')
                ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('add_courses.status', '1')->value('create_letter.course');
                $trainingData = DB::table('presentations')->where('filetype', 'presentation')->where('course', $course)->get();
            return $trainingData;
        } else if (strpos($id, 'announcement-') !== false) {
            $traineeData = TraineesModel::where('email', $traineEmail[1])->max('letterid');
            $letterid = $traineeData;
            $courseid = DB::table('create_letter')->where('letterid', $letterid)->max('course');
            if (!empty($traineeData)) {
                $coursetype = DB::table('add_courses')->where('cid', $courseid)->where('status', '1')->value('coursetype_id');
                $trainingData = DB::table('assignments')
                    ->join('course_types', 'course_types.coursetype_id', '=', 'assignments.trainingtype')
                    ->where('assignments.trainingtype', $coursetype)
                    ->where('assignments.course', $courseid)
                    ->get();
                return $trainingData;
            }
        } else if (strpos($id, 'dataCheck') !== false) {
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }
            $courseId = DB::table('trainees')
                ->join('create_letter', 'trainees.letterid', '=', 'create_letter.letterid')
                ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                ->where('add_courses.status', '1')
                ->where('email', $userEmail)
                ->value('add_courses.cid');
            $exam_id = Examination::where('course', $courseId)->where('exam_status', 1)->value('exam_id');
//            Log::info($exam_id);
            $recordExist = SubmitResult::where('email', $userEmail)->where('course', $courseId)->where('exam_id', $exam_id)->exists();
//            Log::info($recordExist);
            if (empty($recordExist)) {

                $recordExist = 'true';
            } else {
                $recordExist = 'false';
            }
            return $recordExist;
        } else if (strpos($id, 'indData') !== false) {
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }
            $tid = DB::table('create_letter')
                ->join('trainees', 'trainees.letterid', '=', 'create_letter.letterid')
                ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                ->where('trainees.email', $userEmail)->where('add_courses.status', 1)->value('tid');
            $ind_Data = DB::table('indschedual')
                ->join('course_types', 'course_types.coursetype_id', '=', 'indschedual.trainingtype')
                ->where('indschedual.traineetype', $tid)->get();
            return $ind_Data;
        } else
            return '';
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
