<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SubscriptionsResource;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscriptions::all();

        return view('subscriptions.index', compact(['subscriptions']));
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $subscriptions = Subscriptions::get();
        return new SubscriptionsResource($subscriptions);
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
            'image' => 'required',
            'name' => 'required',
            'price' => 'required',
            'desc' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->file('image')) {
            unset($input['image']);
            $input += ['image' => $this->updateprofile($req, 'image', 'profileimage')];
        }

        unset($input['_token']);
        if (@$input['id']) {
            $subscriptions = Subscriptions::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Subscriptions Updated Successfully.']);
        } else {
            $subscriptions = Subscriptions::create($input);
            return response()->json(['success' => true, 'msg' => 'Subscriptions Created Successfully', 'data' => $subscriptions]);
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
        //
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
    public function destroy($id)
    {
        //
    }
}
