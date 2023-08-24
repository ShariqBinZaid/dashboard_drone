<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Http\Resources\PackagesResource;
use App\Models\Packages;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Symfony\Polyfill\Intl\Idn\Idn;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Packages::all();

        return view('packages.index', compact(['packages']));
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $packages = Packages::get();
        return new PackagesResource($packages);
    }


    public function store(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'no_of_session' => 'required',
            'session_time' => 'required',
            'price' => 'required',
        ]);

        $input += ['total_time' => $input['no_of_session'] * $input['session_time']];
        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }
        unset($input['_token']);
        if (@$input['id']) {
            $package = Packages::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Packages Updated Successfully.']);
        } else {
            $saleprice = $input['price'] / 100 * $input['discount_offer'];
            $saleprice = $input['price'] - $saleprice;
            $input += ['sale_price' => $saleprice];
            $package = Packages::create($input);
            return response()->json(['success' => true, 'msg' => 'Packages Created Successfully']);
        }
    }


    public function show($id)
    {
        if ($id ==  "all") {
            $pkg = Packages::all();
            return new PackagesResource($pkg);
        } else {
            $pkg = Packages::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $pkg]);
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, $id)
    {
        Packages::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Packages Deleted Successfully']);
    }
    public function dicountprice(Request $req)
    {
        $originalPrice = Packages::where('id', $req->id)->where('price', $req->price)->get();
        $discountPercentage = 10;
        $discountPercentage = $originalPrice - ($originalPrice * ($discountPercentage / 100));
        return response()->json(['success' => true, 'data' => $discountPercentage]);
    }
}
