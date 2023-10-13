<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Examination;
use App\Model\TraineesModel;
use Illuminate\Support\Facades\Auth;
use App\Model\ResultModel;
use App\Model\ResultReport;
use App\Model\WritePaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        ->inRandomOrder() we can this as well
      if (!empty(session('external')))
      {
          $userEmail = session('useremail');
          if (strcmp('@',$userEmail)) {
              $course = DB::table('create_letter')
                  ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                  ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('add_courses.status','1')->select('create_letter.course')->get();
              $data=DB::table('write_papers')->join('examinations','examinations.exam_id','=','write_papers.exam_id')->where('write_papers.course', $course[0]->course)->where('examinations.exam_status',1)->inRandomOrder()->paginate(100);
//             $data = WritePaper::where('course', $course[0]->course)->where()->paginate(100);
              return $data;
          }
      }
      else
      {
          $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
          if (strcmp('@',$userEmail)) {
              $course = DB::table('create_letter')
                  ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                  ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('add_courses.status','1')->select('create_letter.course')->get();
              $data=DB::table('write_papers')->join('examinations','examinations.exam_id','=','write_papers.exam_id')->where('write_papers.course', $course[0]->course)->where('examinations.exam_status',1)->inRandomOrder()->paginate(100);
              return $data;
          }
      }
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
        if (!strcmp($id, 'attempted')) {
            if (!empty(session('external')))
            {
                $userEmail = session('useremail');
                $course = DB::table('create_letter')
                    ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                    ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('add_courses.status','1')->select('create_letter.course')->value('course');
                $exam_id=Examination::where('course',$course)->where('exam_status',1)->value('exam_id');
                $countMcqs=DB::table('result_reports')->where('course',$course)->where('exam_id',$exam_id)->where('userid',session('userid'))->count();
                return $countMcqs;
            }
            else
            {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
                $course = DB::table('create_letter')
                    ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                    ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('add_courses.status','1')->select('create_letter.course')->value('course');
                $exam_id=Examination::where('course',$course)->where('exam_status',1)->value('exam_id');
                $countMcqs=DB::table('result_reports')->where('course',$course)->where('exam_id',$exam_id)->where('userid',session('userid'))->count();
                  return $countMcqs;
            }
        }
        if (!strcmp($id, 'totalMcqs')) {

            if (!empty(session('external')))
            {
                $userEmail = session('useremail');
                if (strcmp('@',$userEmail)) {
                    $course = DB::table('create_letter')
                        ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                        ->join('examinations', 'examinations.course', 'create_letter.course')
                        ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('examinations.exam_status',1)->where('add_courses.status','1')->value('create_letter.course');
                    $exam_id=Examination::where('course',$course)->where('exam_status',1)->value('exam_id');
                    $data = WritePaper::where('course', $course)->where('exam_id',$exam_id)->count();
                    return $data;
                }
            }
            else
            {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
//                $currentDate=Date('Y-m-d');
                if (strcmp('@',$userEmail)) {
                    $course = DB::table('create_letter')
                        ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                        ->join('examinations', 'examinations.course', 'create_letter.course')
                        ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('examinations.exam_status',1)->where('add_courses.status','1')->value('create_letter.course');
                    $exam_id=Examination::where('course',$course)->where('exam_status',1)->value('exam_id');
                    $data = WritePaper::where('course', $course)->where('exam_id',$exam_id)->count();
                    return $data;
                }
            }
        } else {
            if (!empty(session('external'))) {
                $userEmail = session('useremail');
            } else {
                $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
            }

            $course = DB::table('create_letter')
                ->join('add_courses', 'add_courses.cid', 'create_letter.course')
                ->join('examinations', 'examinations.course', 'create_letter.course')
                ->join('trainees', 'trainees.letterid', 'create_letter.letterid')->where('trainees.email', $userEmail)->where('examinations.exam_status',1)->where('add_courses.status','1')->value('create_letter.course');
            $exam_id=Examination::where('course',$course)->where('exam_status',1)->value('exam_id');

            $etime = Examination::where('course', '=', $course)->where('exam_id',$exam_id)->value('etime');

            return $etime;
        }
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
         $getAns = WritePaper::where('paperid', $id)->first();
         if (!empty(session('external')))
         {
             $userEmail = session('useremail');
         }
         else{
             $userEmail = session('useremail')[0] . '@' . session('useremail')[1];
         }

        $letterId=DB::table('trainees')
            ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
            ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
            ->where('add_courses.status', '=', '1')
            ->where('trainees.email', '=', $userEmail)
            ->value('trainees.letterid');

         $course = DB::table('create_letter')
            ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
            ->where('create_letter.letterid', $letterId)->where('add_courses.status','1')->value('course');
         $exam_id=DB::table('examinations')->where('exam_status','1')->where('course',$course)->value('exam_id');
         $check = ResultReport::where('paperid', $id)->where('userid', session('userid'))->where('course',$course)->first();
        if (!strcmp($getAns['answer'], $request['selected'])) {
            if (empty($check['rp_id'])) {
                ResultReport::create([
                    'paperid' => $id,
                    'userid' => session('userid'),
                    'selected' => $request['selected'],
                    'flag' => 1,
                    'course' => $course,
                    'exam_id'=>$exam_id
                ]);
                return 1;
            } else {
                $checkRecord = ResultReport::find($check['rp_id']);
                $checkRecord->paperid = $id;
                $checkRecord->userid = session('userid');
                $checkRecord->selected = $request['selected'];
                $checkRecord->flag = 1;
                $checkRecord->course = $course;
                $checkRecord->exam_id = $exam_id;
                $checkRecord->save();
                return 0;
            }
        } else {
            if (empty($check['rp_id'])) {
                ResultReport::create([
                    'paperid' => $id,
                    'userid' => session('userid'),
                    'selected' => $request['selected'],
                    'flag' => 0,
                    'course' => $course,
                    'exam_id'=>$exam_id
                ]);
            } else {
                $checkRecord = ResultReport::find($check['rp_id']);
                $checkRecord->paperid = $id;
                $checkRecord->userid = session('userid');
                $checkRecord->selected = $request['selected'];
                $checkRecord->flag = 0;
                $checkRecord->course = $course;
                $checkRecord->exam_id = $exam_id;
                $checkRecord->save();
                return 0;
            }

            return 1;

        }

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
