<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoriesResource;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();

        return view('categories.index', compact(['categories']));
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $categories = Categories::get();
        return new CategoriesResource($categories);
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
    public function store(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'name' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);
        if (@$input['id']) {
            $categories = Categories::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Categories Updated Successfully.']);
        } else {
            $categories = Categories::create($input);
            return response()->json(['success' => true, 'msg' => 'Categories Created Successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id ==  "all") {
            $categories = Categories::all();
            return new CategoriesResource($categories);
        } else {
            $categories = Categories::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $categories]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        Categories::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Categories Deleted Successfully']);
    }

    public function getcategories()
    {
        $getcategories = Categories::get();
        return response()->json(['success' => true, 'data' => $getcategories]);
    }
}
