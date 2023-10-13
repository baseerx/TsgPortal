<?php

namespace App\Http\Controllers;

use App\Model\MainMenu;
use App\Model\SubMenu;
use App\UserRight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MainMenuController extends Controller
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

        return MainMenu::paginate(2);
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
        return MainMenu::create([
            'mmenuDesc' => $request['mname'],
            'mmenuURL' => $request['murl'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\MainMenu $mainMenu
     * @return \Illuminate\Http\Response
     */
    public function show(MainMenu $mainMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\MainMenu $mainMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(MainMenu $mainMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\MainMenu $mainMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'title' => 'required|string|max:191',
            'murl' => 'required|string|max:191',
        ]);


        $userId = MainMenu::find($id);
        $userId->mmenuDesc = $request->input('title');
        $userId->mmenuURL = $request->input('murl');
        $userId->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\MainMenu $mainMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sData = SubMenu::where('mmenuId', $id)->get();
        $uData = UserRight::where('mmenuId', $id)->get();
        if (count($sData) > 0 && count($uData) > 0)
            return false;
        else
            return MainMenu::destroy($id);
    }
}
