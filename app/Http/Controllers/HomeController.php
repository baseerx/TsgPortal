<?php

namespace App\Http\Controllers;

use App\UserRight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $data = UserRight::where('uId', $user['id'])->get();

        return view('home')->with('data', $data)->with('data1', $data);
    }

    public function checkHris()
    {
        return DB::connection('mysql2')->table('department')->get();
    }

}
