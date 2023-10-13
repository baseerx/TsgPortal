<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\MainScreen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MainScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data=MainScreen::all();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
//        $validate=$request->validate([
//        'uid' =>'required',
//        'datetime' =>'required',
//        'lassetno' =>'required',
//        'tangorintang' =>'required',
//        'companycode' =>'required',
//        'assettype' =>'required',
//        'classification' =>'required',
//        'category' =>'required',
//        'units' =>'required',
//        'detaildesc' =>'required',
//        'ownedorleased' =>'required',
//        'location' =>'required',
//        'assetcost' =>'required',
//         'currentcost' =>'required',
//        'scrapvalue' =>'required',
//        'captdate' =>'required',
//        'acqdate' =>'required',
//        'usefullife' =>'required',
//        'depmethod' =>'required',
//        'deprate' =>'required',
//        'depreciation' =>'required',
//        'accumdep' =>'required',
//        'depchargeacc' =>'required',
//        'revdate' =>'required',
//        'planretirdate' =>'required',
//        'lagreementdate' =>'required',
//        'lstartdate' =>'required',
//        'inuse' =>'required',
//        'inphysicalinv'=>'required',
//        'indicator' =>'required',
//        ]);
        Log::info($request->all());
        $assetCodeCheck=MainScreen::where('assetcode',$request['assetcode'])->exists();
        // Log::info($assetCodeCheck);
        if(empty($assetCodeCheck) || isNull($request['assetcode']))
        {
            $data=$request->all();
            MainScreen::create($data);
        }
        else
           return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return MainScreen::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
//        Log::info($request->all());
//        Log::info($id);
//        $assetCodeCheck=MainScreen::where('assetcode',$request['assetcode'])->exists();
//        if(empty($assetCodeCheck))
//        {
//
//        }
//       else
//           return abort(404);
        $mainscreen=MainScreen::find($id);
        $mainscreen->fill($request->all())->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return MainScreen::destroy($id);
    }
}
