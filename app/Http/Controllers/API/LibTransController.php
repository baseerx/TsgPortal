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
use Symfony\Component\Console\Helper\Table;

class LibTransController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('transactions')
            ->join('libraries', 'libraries.lid', '=', 'transactions.library')
            ->join('sub_categories', 'sub_categories.sid', '=', 'transactions.scategory')
            ->join('category', 'category.cid', '=', 'transactions.category')
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'library' => 'required',
            'category' => 'required',
            'scategory' => 'required',
            'description' => 'required',
            'dop' => 'required',
            'doe' => 'required',
            'book_code' => 'required|string',
            'author_name' => 'required|string',
            'publisher' => 'required|string',
            'filetype' => 'required',
            'file' => 'required'
        ]);

        $dop = explode('T', $request['dop']);
        $doe = explode('T', $request['doe']);

        $orignalName=explode('.',$request->file->getClientOriginalName());
        $fileNewName = $orignalName[0].time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('libtrans'), $fileNewName);
        LibTrans::create([
            'library' => $request['library'],
            'category' => $request['category'],
            'scategory' => $request['scategory'],
            'description' => $request['description'],
            'dop' => $dop[0],
            'doe' => $doe[0],
            'price'=>$request['price'],
            'book_code' => $request['book_code'],
            'author_name' => $request['author_name'],
            'publisher' => $request['publisher'],
            'distributor'=>$request['distributor'],
            'type' => $request['filetype'],
            'file' => $fileNewName,
            'filedesc' => $request['filedesc'],
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
        if(strpos($id,'cat_')!== false)
        {

            $cid=explode('_',$id);
            return LibTrans::where('category',$cid[1])->get();
        }
        else
        return LibTrans::find($id);
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
        'library' => 'required',
        'category' => 'required',
        'scategory' => 'required',
        'description' => 'required',
        'dop' => 'required|date',
        'doe' => 'required|date',
        'book_code' => 'required|string',
        'author_name' => 'required|string',
        'publisher' => 'required|string',
    ]);
        $dop = explode('T', $request['dop']);
        $doe = explode('T', $request['doe']);

        $toSave = LibTrans::find($id);

        $toSave->library = $request['library'];
        $toSave->category = $request['category'];
        $toSave->scategory = $request['scategory'];
        $toSave->description = $request['description'];
        $toSave->dop = $dop[0];
        $toSave->doe = $doe[0];
        $toSave->price = $request['price'];
        $toSave->book_code = $request['book_code'];
        $toSave->author_name = $request['author_name'];
        $toSave->publisher = $request['publisher'];
        $toSave->distributor = $request['distributor'];
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
//        $data = LibTrans::find($id);
//        $lcheck = Library::find($data['library'])->exists();
//        $scheck = SubCategory::find($data['scategory'])->exists();
//        $ccheck = CategoryModel::find($data['category'])->exists();
//        if ($lcheck || $scheck || $ccheck) {
//            abort(404, 'Data already exists in Parent tables..');
//        } else {
            return LibTrans::destroy($id);
//        }
    }
}
