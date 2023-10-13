<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\FeedBack;
use App\Model\TraineesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeedBackController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty(session('external')))
        $email=session('useremail');
        else
        $email=session('useremail')[0].'@'.session('useremail')[1];

        $letterid=DB::table('trainees')
            ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
            ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
            ->where('add_courses.status', '=', '1')
            ->where('trainees.email', '=', $email)
            ->value('trainees.letterid');

        $currentCourse = DB::table('create_letter')
            ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
            ->where('create_letter.letterid', $letterid)->value('course');
        
        $vals=explode('-',$request['feedback']);
        $check=FeedBack::where('question',$vals[1])->where('userid',session('userid'))->value('fid');
        if ($check)
        {

            $this->update($vals[0],$check);
        }
        else
        {
            FeedBack::create([
                'course'=>$currentCourse,
                'question'=>$vals[1],
                'option'=>$vals[0],
                'userid'=>session('userid')
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update($option,$fid)
    {
        $toSave=FeedBack::find($fid);
        $toSave->option=$option;
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
        //
    }
}
