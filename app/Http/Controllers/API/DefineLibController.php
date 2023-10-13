<?php

namespace App\Http\Controllers\API;

use App\Model\CourseSchedule;
use App\Model\DefineLibrary;
use App\Model\Instructor;
use App\Model\Library;
use phpDocumentor\Reflection\File;
use function GuzzleHttp\Psr7\str;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class DefineLibController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=DB::table('define_library')
            ->join('libraries','libraries.lid','=','define_library.category')
            ->paginate(10);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'author'=>'required',
           'description'=>'required',
           'file'=>'required',
        ]);
        $orignalName=explode('.',$request->file->getClientOriginalName());
        $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('library'), $fileNewName);

        return DefineLibrary::create([
           'author'=>$request['author'],
           'description'=>$request['description'],
           'filename'=>$fileNewName,
           'category'=>$request['category'],
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
           if (strpos($id,'lib-')!==false)
           {
               $val=explode('-',$id);
               return DefineLibrary::find($val[1]);
           }
           else
           {
               return Library::all();
           }

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
        if (!strcmp($request['file'],'undefined'))
        {
            $toSave=DefineLibrary::find($id);
            $toSave->author=$request['author'];
            $toSave->description=$request['description'];
            $toSave->category=$request['category'];
            $toSave->save();
        }
        else{
            $request->validate([
                'author'=>'required',
                'description'=>'required',
                'file'=>'required',
            ]);
            $toSave=DefineLibrary::find($id);
            $fileStr=strval($toSave['filename']);
            unlink(public_path('library/'.$fileStr));
            $toSave->author=$request['author'];
            $toSave->description=$request['description'];
            $orignalName=explode('.',$request->file->getClientOriginalName());
            $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('library'), $fileNewName);
            $toSave->filename=$fileNewName;
            $toSave->category=$request['category'];
            $toSave->save();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DefineLibrary::destroy($id);
    }
}
