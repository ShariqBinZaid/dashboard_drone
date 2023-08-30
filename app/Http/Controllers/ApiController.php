<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'country' => 'required',
            'address' => 'required',
            'desc' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $users  = User::where('email', $request['email'])->get();
        if ($users->count() > 0) {
            return response()->json(['success' => false, 'msg' => 'Email Already Exist']);
            die;
        }

        if ($request->file('display_picture')) {
            unset($input['display_picture']);
            $input += ['display_picture' => $this->updateprofile($request, 'display_picture', 'profileimage')];
        }

        // return $input;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user;

        return $this->sendResponse($success, 'User Registered Successfully.');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            // $success['email'] =  $user->email;
            $success['user'] =  $user;
            return $this->sendResponse($success, 'User Login Successfully.');
        } else {
            return $this->sendResponse('Unauthorised.', ['error' => 'Email or Password Incorrect']);
            // return $this->sendError('Unauthorised.', ['error' => 'Incorrect ID Password']);
        }
    }
    public function userupdate(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'user_type' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }
        unset($input['_token']);
        if (@$input['id']) {
            $userupdate = User::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.']);
        } else {
            $userupdate = User::create($input);
            return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
        }
    }
    public function phoneotp(Request $req)
    {
        $otp = User::where('id', $req->user_id)->where('otp', $req->otp)->first();
        if (!empty($otp)) {
            return response()->json(['success' => true, 'msg' => 'Success']);
        }
        return response()->json(['success' => false, 'msg' => 'Please enter valid otp code']);
    }

    public function locations(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            // 'first_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }
        
        $input += ['user_id' => Auth::id()];
        unset($input['_token']);
        if (@$input['id']) {
            $userupdate = User::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.']);
        } else {
            $userupdate = User::create($input);
            return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
        }
    }

    public function getlocations(Request $request)
    {
        $ip = $request->ip();
        // dd($ip);
        // $ip = '1';
        $userLocations = Location::get($ip);
        return response()->json(['success' => true, 'msg' => 'Location Get Successfully', 'data' => $userLocations]);
    }
}
