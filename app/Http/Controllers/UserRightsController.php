<?php

namespace App\Http\Controllers\API;

use App\Model\SubMenu;
use App\Model\MainMenu;
use App\User;
use App\UserRight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRightsController extends Controller
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
        return DB::select('SELECT * FROM sub_menus ORDER BY mmenuId');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return UserRight::where('uId', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
          Log::info($request->all());
          Log::info($id);
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRight::destroy($id);
    }
}
