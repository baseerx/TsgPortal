<?php

namespace App\Http\Controllers\API;
use App\Model\TraineesModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use MongoDB\Driver\Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return User::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:4',
            'user_type' => 'required',
        ]);
       return User::create([
           'name'=>$request['name'],
           'email'=>$request['email'],
           'password'=>Hash::make($request['password']),
           'remember_token' => Str::random(10),
           'user_type'=>$request['user_type']
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
          Log::info($id);
        if (!strcmp($id,'presentation'))
        {
            $letterid=DB::table('create_letter')
                ->join('add_courses','add_courses.cid','=','create_letter.course')
                ->where('add_courses.status','1')
                ->pluck('letterid');
            return TraineesModel::whereIn('letterid',$letterid)->get();
        }
        elseif (!strcmp($id,'username'))
        {
               Log::info(session('username'));
            return session('username');
        }
        else
        {
            $values=DB::table('users')->where('id',$id)->select( 'name','email','user_type')->get();
            return $values;
        }
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

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'user_type' => 'required'
        ]);
       $toSave=User::find($id);
       $toSave->name=$request->input('name');
       $toSave->email=$request->input('email');
       $toSave->user_type=$request->input('user_type');
       if (!empty($request['password']))
       {
           $toSave->password=Hash::make($request['password']);
       }
        $toSave->save();

        return $this->index();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=User::find($id);
        if (!strcmp($data['user_type'],'admin'))
        {
            return abort(404);
        }
        else
            return User::destroy($id);

    }
}
