<?php

namespace App\Http\Controllers;

use App\UserRight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserRightController extends Controller
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
//        $user = auth()->user();
        return Auth::user();

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
    public function store($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserRight $userRight
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!strcmp($id,'card_check'))
        {
            $checkid=Auth::user()->id;
            $checkRights=UserRight::where('uId', $checkid)->where('cAdd','true')->exists();
           if (empty($checkRights))
           {
               return 0;
           }
           else
           {
               return 1;
           }
//            Log::info($checkRights);
        }
        else{
            $userId = UserRight::where('uId', $id)->get();
            return $userId;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRight $userRight
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRight $userRight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\UserRight $userRight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        sequence menuinfo edit print delete add
        $userId = $id;
        $data = $request->all();
        $data = explode('&', json_encode($data));
        $dataLength = sizeof($data) - 1;
        $i = 0;


        while ($i < $dataLength) {

            if ($i == 0) {
                $str = explode('"', $data[$i]);

                $str = $str[count($str) - 1];

            } else {
                $str = $data[$i];

            }
            $str = explode('|', $str);


            $menuInfo = explode('-', $str[0]);
            $edit = $str[1];
            $print = $str[2];
            $delete = $str[3];
            $add = $str[4];
            $mmenu = $str[5];
            $smenu = $str[6];


            if (UserRight::where('uId', '=', $id)->count() > 0 && $i == 0) {
                $this->destroy($id);
                UserRight::create([

                    'uId' => $id,
                    'mmenuId' => $menuInfo[0],
                    'smenuId' => $menuInfo[1],
                    'cEdit' => $str[1],
                    'cPrint' => $str[2],
                    'cDelete' => $str[3],
                    'cAdd' => $str[4]

                ]);
                $i++;

            } else {

//                    Log::info($menuInfo[0].$menuInfo[1]."edit=".$str[1]. "print=".$str[2]. "delete=".$str[3]. "add=".$str[4]);
                UserRight::create([

                    'uId' => $id,
                    'mmenuId' => $menuInfo[0],
                    'smenuId' => $menuInfo[1],
                    'cEdit' => $str[1],
                    'cPrint' => $str[2],
                    'cDelete' => $str[3],
                    'cAdd' => $str[4]

                ]);
                $i++;

            }


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRight $userRight
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRight::destroy($id);
    }
}
