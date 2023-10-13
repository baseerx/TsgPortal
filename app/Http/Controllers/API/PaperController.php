<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\WritePaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WritePaper::paginate(5);
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
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required|in:A,B,C,D,E',
            'papertype' => 'required',
            'course' => 'required',
            'exam_id' => 'required'
        ]);
        WritePaper::create([
            'question' => $request['question'],
            'first' => $request['first'],
            'second' => $request['second'],
            'third' => $request['third'],
            'fourth' => $request['fourth'],
            'fifth' => $request['fifth'],
            'answer' => $request['answer'],
            'papertype' => $request['papertype'],
            'course' => $request['course'],
            'exam_id' => $request['exam_id']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (strpos($id, 'examid-') !== false)
        {
            $eid=explode('-',$id);
            $data=DB::table('write_papers')
                ->join('examinations','examinations.exam_id','=','write_papers.exam_id')
                ->where('write_papers.exam_id',$eid[1])->paginate(12);
            return $data;
        }
        else
        return WritePaper::find($id);
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
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required|in:A,B,C,D,E',
            'papertype' => 'required',
            'course' => 'required',
            'exam_id'=>'required'
        ]);
        $toSave = WritePaper::find($id);

        $toSave->question = $request['question'];
        $toSave->first = $request['first'];
        $toSave->second = $request['second'];
        $toSave->third = $request['third'];
        $toSave->fourth = $request['fourth'];
        $toSave->fifth = $request['fifth'];
        $toSave->answer = $request['answer'];
        $toSave->papertype = $request['papertype'];
        $toSave->course = $request['course'];
        $toSave->exam_id = $request['exam_id'];
        $toSave->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WritePaper::destroy($id);
    }
}
