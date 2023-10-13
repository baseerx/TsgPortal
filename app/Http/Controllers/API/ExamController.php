<?php

namespace App\Http\Controllers\API;

use App\Model\AddCourse;
use App\Model\Examination;
use App\Model\LetterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\Promise\all;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('examinations')
            ->join('add_courses', 'add_courses.cid', '=', 'examinations.course')
            ->join('instructors', 'instructors.ins_id', '=', 'examinations.instructor')
            ->paginate(12);
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

        $validateDate = $request->validate([
            'course' => 'required',
            'schedules' => 'required',
            'instructor' => 'required',
            'marks' => 'required',
            'center' => 'required',
            'examtitle' => 'required',
            'exam_status' => 'required'
        ]);

        $date = date('Y-m-d', strtotime($request['date']));
        $stime = explode(',',$request['stime']);
        $etime = explode(', ',$request['etime']);

        $check=Examination::where('exam_status',1)->where('date',$date)->where('course','=',$request['course'])->exists();
        if (empty($check))
        {
            Examination::create([
                'course' => $request['course'],
                'schedules' => $request['schedules'],
                'instructor' => $request['instructor'],
                'center' => $request['center'],
                'date' => $date,
                'stime' => $stime[1],
                'etime' => $etime[1],
                'marks' => $request['marks'],
                'examtitle' => $request['examtitle'],
                'exam_status' => $request['exam_status'],
            ]);
        }
        else
            abort(404,'already scheduled in this slab..');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (strpos($id,'trainee_')!==false)
        {
            if (!empty(session('external')))
            {
                $email=session('useremail');

                $letterid=DB::table('trainees')
                    ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                    ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                    ->join('examinations', 'examinations.course', '=', 'add_courses.cid')
                    ->where('add_courses.status', '=', '1')
                    ->where('trainees.email', '=', $email)
                    ->value('trainees.letterid');

                $data=LetterModel::find($letterid);
                $currentDate=date('Y-m-d');
                $examData=Examination::where('course',$data['course'])->where('date',$currentDate)->where('instructor',$data['instructor'])->where('exam_status', '=', 1)->get();
                return $examData;
            }
            else
            {
                $email=session('useremail')[0].'@'.session('useremail')[1];
//                $letterid=DB::table('trainees')
//                    ->where('trainees.email',$email)->value('letterid');

                $letterid=DB::table('trainees')
                    ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                    ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                    ->join('examinations', 'examinations.course', '=', 'add_courses.cid')
                    ->where('add_courses.status', '=', '1')
                    ->where('trainees.email', '=', $email)
                    ->value('trainees.letterid');

                $data=LetterModel::find($letterid);
                $currentDate=date('Y-m-d');
                $examData=Examination::where('course',$data['course'])->where('exam_status', '=', 1)->where('date',$currentDate)->where('instructor',$data['instructor'])->get();
//                Log::info("exam_data".$examData);
                return $examData;
            }

        }
        elseif (strpos($id,'tEmail-')!==false)
        {
            $email=explode('-',$id);
            if (!empty(session('external')))
            {
                $email=session('useremail');
                $data=DB::table('trainees')
                    ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                    ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                    ->join('examinations', 'examinations.course', '=', 'add_courses.cid')
                    ->where('add_courses.status', '=', '1')
                    ->where('trainees.email', '=', $email)
                    ->get();
                return $data;
            }
            else
            {
                $email=session('useremail')[0].'@'.session('useremail')[1];
                $data=DB::table('trainees')
                    ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                    ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                    ->join('examinations', 'examinations.course', '=', 'add_courses.cid')
                    ->where('add_courses.status', '=', '1')
                    ->where('trainees.email', '=', $email)
                    ->get();
                return $data;
            }

        }
        elseif ((strpos($id, '_courseId') !== false))
        {

            $cid=explode('_',$id);
            $data = DB::table('examinations')
                ->join('add_courses', 'add_courses.cid', '=', 'examinations.course')
                ->join('instructors', 'instructors.ins_id', '=', 'examinations.instructor')
                ->where('course',$cid[0])
                ->paginate(4);
            return $data;
        }
        elseif((strpos($id, 'examdata_') !== false))
        {
            $examId=explode('_',$id);
            return Examination::where('course',$examId[1])->get();
        }
        elseif(strpos($id, '_examId') !== false)
        {
            $data=DB::table('add_courses')->join('examinations','examinations.course','=','add_courses.cid')->where('add_courses.status',1)->get();
            return $data;
        }
        else
            return Examination::find($id);
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
        $toSave = Examination::find($id);
        $validateDate = $request->validate([
            'course' => 'required|numeric',
            'schedules' => 'required|numeric',
            'instructor' => 'required|numeric',
            'marks' => 'required|numeric',
            'center' => 'required',
            'examtitle' => 'required',
            'exam_status' => 'required',
        ]);

        $check=Examination::where('stime',$request['stime'])->where('etime',$request['etime'])->where('exam_id','!=',$id)->where('course','=',$toSave['course'])->exists();
        if (empty($check)) {
            $date = date('Y-m-d', strtotime($request['date']));
            $toSave->course = $request['course'];
            $toSave->schedules = $request['schedules'];
            $toSave->instructor = $request['instructor'];
            $toSave->center = $request['center'];
            $toSave->date = $date;
            $toSave->stime = $request['stime'];
            $toSave->etime = $request['etime'];
            $toSave->marks = $request['marks'];
            $toSave->examtitle = $request['examtitle'];
            $toSave->exam_status = $request['exam_status'];
            $toSave->save();
        }
        else
            abort(404,'record already scheduled in this time slab..or please check carefully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check=Examination::find($id);
        // Log::info($check);
        if($check['exam_status']===0)
            Examination::destroy($id);
        else
            abort(404,'exam is active therefore you cant delete it');
    }
}
