<?php

namespace App\Http\Controllers;

use App\Model\SubMenu;
use App\Model\MainMenu;
use App\User;
use App\UserRight;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;

class SubMenuController extends Controller
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
        return SubMenu::paginate(4);
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
        $mRecord = MainMenu::where('mmenuDesc', $request['Menu'])->first();
//        $user = auth::user();
        SubMenu::create([
            'smenuDesc' => $request['sName'],
            'smenuURL' => $request['sUrl'],
            'mmenuId' => $mRecord['mmenuId'],
            'sOrder' => $request['Sort'],
            'mmenuDesc' => $mRecord['mmenuDesc'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\SubMenu $subMenu
     * @return \Illuminate\Http\Response
     */
    public function show($val)
    {
        if (!strcmp($val, 'All')) {
            return MainMenu::all();
        } else {
            return SubMenu::find($val);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\SubMenu $subMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(SubMenu $subMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\SubMenu $subMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateFlag = SubMenu::find($id);
//        Log::info($updateFlag);
        $updateFlag->smenuDesc = $request['sName'];
        $updateFlag->smenuURL = $request['sUrl'];
        $updateFlag->sOrder = $request['Sort'];
        $updateFlag->mmenuDesc = $request['Menu'];
        $updateFlag->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\SubMenu $subMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRight::where('smenuId', $id)->delete();
        return SubMenu::destroy($id);
    }
}
