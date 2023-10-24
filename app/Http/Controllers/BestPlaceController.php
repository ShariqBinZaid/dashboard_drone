<?php

namespace App\Http\Controllers;

use App\Models\BestPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BestPlaceResource;
use Illuminate\Support\Facades\Validator;

class BestPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $place = BestPlace::all();

        return view('place.index', compact(['place']));
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $place = BestPlace::with('getUser')->get();
        return new BestPlaceResource($place);
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
            'title' => 'required',
            'loc' => 'required',
            'desc' => 'required',
            'file' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->file('file')) {
            unset($input['file']);
            $input += ['file' => $this->updateprofile($req, 'file', 'profileimage')];
        }

        $input += ['user_id' => Auth::id()];
        unset($input['_token']);
        if (@$input['id']) {
            $bestplace = BestPlace::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'BestPlace Updated Successfully.']);
        } else {
            $bestplace = BestPlace::create($input);
            return response()->json(['success' => true, 'msg' => 'BestPlace Created Successfully', 'data' => $bestplace]);
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
            $subscriptions = BestPlace::all();
            return new BestPlaceResource($subscriptions);
        } else {
            $subscriptions = BestPlace::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $subscriptions]);
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
        BestPlace::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'BestPlace Deleted Successfully']);
    }
    public function getplace()
    {
        $getplace = BestPlace::with('getUser')->get();
        return response()->json(['success' => true, 'data' => $getplace]);
    }
}
