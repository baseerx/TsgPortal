<?php

namespace App\Http\Controllers\API;

use App\Model\CategoryModel;
use App\Model\Library;
use App\Model\LibTrans;
use App\Model\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\Cloner\Data;

class SubCatController extends Controller
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
        $Data=DB::table('sub_categories')
           ->join('category','category.cid','=','sub_categories.cid')
           ->paginate(12);
        return $Data;
//       return SubCategory::paginate(4);
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
        $validate=$request->validate([
           'cid'=>'required',
           'slibrary'=>'required',
        ]);
        SubCategory::create([
           'cid'=>$request['cid'],
           'slibrary'=>$request['slibrary'],
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
        if (!strcmp($id,'libdata'))
        {
            return Library::all();
        }
        elseif (!strcmp($id,'slibtrans'))
        {
            return SubCategory::all();
        }
        else
        {
            return SubCategory::find($id);
        }
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
        $request->validate([
           'cid'=>'required',
           'slibrary'=>'required',
        ]);
        $toSave=SubCategory::find($id);
        $toSave->cid=$request['cid'];
        $toSave->slibrary=$request['slibrary'];
        $toSave->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lid=DB::table('sub_categories')->where('sid',$id)->value('cid');
        $check=CategoryModel::where('cid',$lid)->exists();
        if ($check)
        {
            abort(404,'Data exists in parent table');
        }
        else
        {
            return SubCategory::destroy($id);
        }
    }

}
