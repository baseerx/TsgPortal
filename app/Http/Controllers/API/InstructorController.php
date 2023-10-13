<?php

namespace App\Http\Controllers\API;

use App\Model\CourseSchedule;
use App\Model\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Instructor::paginate(4);
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
        $validate = $request->validate([
            'name' => 'required|string',
            'title' => 'required|string',
            'dob' => 'required|date',
            'phone' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email',
        ]);
        $dob = explode('T', $request['dob']);
        Instructor::create([
            'name' => $request['name'],
            'title' => $request['title'],
            'dob' => $dob[0],
            'phone' => $request['phone'],
            'mobile' => $request['mobile'],
            'email' => $request['email'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!strcmp($id,'all'))
        {
            return Instructor::all();
        }
        else
        return Instructor::find($id);
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
        $toSave = Instructor::find($id);
        $validate = $request->validate([
            'name' => 'required|string',
            'title' => 'required|string',
            'dob' => 'required',
            'phone' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email',
        ]);
        if (strpos($request['dob'], 'T') !== false) {
            $dob = explode('T', $request['dob']);
            $toSave = Instructor::find($id);

            $toSave->name = $request['name'];
            $toSave->title = $request['title'];
            $toSave->dob = $dob[0];
            $toSave->phone = $request['phone'];
            $toSave->mobile = $request['mobile'];
            $toSave->email = $request['email'];
            $toSave->save();
        } else {

            $toSave->name = $request['name'];
            $toSave->title = $request['title'];
            $toSave->dob = $request['dob'];
            $toSave->phone = $request['phone'];
            $toSave->mobile = $request['mobile'];
            $toSave->email = $request['email'];
            $toSave->save();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check=CourseSchedule::where('instructor','=',$id)->exists();
        if ($check)
        {
            abort(405,'Instructor cant be deleted..');
        }
        else
        Instructor::destroy($id);
    }
}
