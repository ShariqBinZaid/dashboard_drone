<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Packages;
use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\UserFollowers;
use App\Models\UserFollowings;
use App\Models\UserLikes;
use App\Models\UserShares;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'desc' => 'required',
                'email' => 'required',
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

            $input += ['user_type' => 'user'];
            // return $input;
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] =  $user;

            return $this->sendResponse($success, 'User Registered Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function registerdelete(Request $req, $id)
    {
        try {
            $email = $req->input('email');
            $password = $req->input('password');

            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json(['success' => false, 'msg' => 'User not found'], 404);
            }

            if (password_verify($password, $user->password)) {
                $user->delete();

                return response()->json(['success' => true, 'msg' => 'User Deleted Successfully']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Email or Password is Incorrect'], 401);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function registerupdate(Request $req)
    {
        try {
            $input = $req->all();
            $validator = Validator::make($input, [
                // 'display_picture' => 'required',
                // 'user_name' => 'required',
                // 'first_name' => 'required',
                // 'last_name' => 'required',
                // 'gender' => 'required',
                // 'email' => 'required',
                // 'dob' => 'required',
                // 'phone' => 'required',
                // 'status' => 'required',
                // 'is_active' => 'required',
                // 'user_type' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            if ($req->file('display_picture')) {
                unset($input['display_picture']);
                $input += ['display_picture' => $this->updateprofile($req, 'display_picture', 'profileimage')];
            }

            if (array_key_exists('category_id', $input)) {
                unset($input['category_id']);
            }

            unset($input['_token']);

            if (@$input['id']) {
                $userupdate = User::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'User Updated Successfully.', 'data' => User::with('getCategory')->where('id', $input['id'])->first()]);
            } else {
                $userupdate = User::create($input);
                return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function changepassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'current_password' => 'required'
            ]);
            $user = User::find(Auth::id());
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return $this->sendResponse($user, 'Password changed successfully!');
            } else {
                return $this->sendError('Current password mismatch!');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;

            $success['user'] =  User::with('getCategory')->find($user->id);

            return $this->sendResponse($success, 'User Login Successfully.');
        } else {
            return $this->sendResponse('Unauthorised.', ['error' => 'Email or Password Incorrect']);
        }
    }


    public function userupdate(Request $req)
    {
        try {
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
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
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
        $getlocations = Location::get($ip);
        return response()->json(['success' => true, 'msg' => 'Location Get Successfully', 'data' => $getlocations]);
    }

    public function userfollowers(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'follower_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $checkFollower = UserFollowers::where('user_id', $input['user_id'])->where('follower_id', $input['follower_id'])->get();
        if ($checkFollower->count() > 0) {
            foreach ($checkFollower as $check) {
                UserFollowers::where('id', $check->id)->delete();
            }

            return response()->json(['success' => true, 'msg' => 'User UnFollow Successfully', 'data' => []]);
        }

        $followerinsert = UserFollowers::create($input);
        return response()->json(['success' => true, 'msg' => 'User Followed Successfully', 'data' => $followerinsert]);
    }

    public function getusersfollowers($post_id)
    {
        $usersfollower = UserFollowers::with('getUserFollower')->where('post_id', $post_id)->first();
        return response()->json(['success' => true, 'data' => $usersfollower]);
    }

    public function followercheck($user_id, $follower_id)
    {
        $followcheck = UserFollowers::where('user_id', $user_id)->where('follower_id', $follower_id)->exists();

        if (!$followcheck) {
            return response()->json(['success' => true, 'msg' => 'User Not Followed']);
        }

        return response()->json(['success' => true, 'msg' => 'User Already Followed']);
    }

    public function usershares(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            // 'user_id' => 'required',
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input += ['user_id' => Auth::id()];

        unset($input['_token']);

        if (@$input['id']) {
            $usershare = UserShares::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Shares Updated Successfully.']);
        } else {
            $usershare = UserShares::create($input);
            return response()->json(['success' => true, 'msg' => 'User Shares Successfully', 'data' => $usershare]);
        }
    }

    public function getusershares($post_id)
    {
        $getusershares = UserShares::where('post_id', $post_id)->get();
        return response()->json(['success' => true, 'data' => $getusershares]);
    }

    public function followUnfollow(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'follower_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        unset($input['_token']);

        $userfollow = UserFollowers::where('user_id', $input['user_id'])->where('follower_id', $input['follower_id'])->first();

        if ($userfollow) {
            $userfollow->delete();
            return response()->json(['success' => true, 'msg' => 'User UnFollow Successfully']);
        } else {
            $userfollow = UserFollowers::create($input);
            return response()->json(['success' => true, 'msg' => 'User Followed Successfully', 'data' => $userfollow]);
        }
    }

    public function myfollowers()
    {
        $myfollowers = UserFollowers::with('getUser')->where('user_id', Auth::user()->id)->get();
        return response()->json(['success' => true, 'data' => $myfollowers]);
    }

    public function followersremove($follower_id)
    {
        $followersremove = UserFollowers::where('follower_id', $follower_id)->forcedelete();
        return response()->json(['success' => true, 'msg' => 'Followers Deleted Successfully']);
    }

    public function unfollow(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'follower_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        unset($input['_token']);

        $userfollow = UserFollowers::where('user_id', $input['user_id'])->where('follower_id', $input['follower_id'])->first();

        if ($userfollow)
            $userfollow->delete();
        return response()->json(['success' => true, 'msg' => 'User UnFollow Successfully']);
    }

    public function allpostlikes($post_id)
    {
        $postLikes = UserLikes::where('post_id', $post_id)->get();
        $likedByUsers = [];

        foreach ($postLikes as $like) {
            $likedByUsers[] = $like->user;
        }

        return response()->json(['success' => true, 'data' => $likedByUsers]);
    }

    public function followersrequest(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            // 'user_id' => 'required',
            'follower_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input += ['user_id' => Auth::user()->id];
        $input += ['status' => 'pending'];

        if (@$input['id']) {
            $followersrequest = UserFollowers::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Followers Updated Successfully.']);
        } else {
            $followersrequest = UserFollowers::create($input);
            $followersrequest = UserFollowers::with('getUser')->get();
            return response()->json(['success' => true, 'msg' => 'User Followed Requested Successfully', 'data' => $followersrequest]);
        }
    }

    public function getfollowersrequest()
    {
        $getfollowersrequest = UserFollowers::with('getUser.getCategory')->where('user_id', Auth::user()->id)->get();
        return response()->json(['success' => true, 'msg' => 'User Followed Requested Successfully', 'data' => $getfollowersrequest]);
    }

    public function followaccept(Request $req)
    {
        try {
            $input = $req->all();
            $validator = Validator::make($input, [
                'follower_id' => 'required',
                // 'status' => 'required|in:accepted,rejected',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            $user = Auth::user();

            // Check if a record already exists for this user and follower
            $existingRecord = UserFollowers::where('user_id', $user->id)->where('follower_id', $input['follower_id'])->first();

            if ($existingRecord) {
                // If a record exists, update the status
                $existingRecord->status = $input['status'];
                $existingRecord->save();
                return response()->json(['success' => true, 'msg' => 'User Followers Accept or Reject.', 'data' => $existingRecord]);
            } else {
                // If no record exists, create a new one
                $input['user_id'] = $user->id;
                $input['status'] = 'pending';
                $followersrequest = UserFollowers::create($input);
                return response()->json(['success' => true, 'msg' => 'User Followed Request Successfully', 'data' => $followersrequest]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function report(Request $req)
    {
        try {
            $input = $req->all();
            $validator = Validator::make($input, [
                // 'user_id' => 'required',
                'desc' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            // $input += ['user_id' => Auth::id()];

            if (@$input['id']) {
                $report = Reports::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'Reports Updated Successfully.', 'data' => $report]);
            } else {
                $report = Reports::create($input);
                // $report = Reports::with('getUser')->first();
                return response()->json(['success' => true, 'msg' => 'Reported Successfully', 'data' => $report]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getacceptfollower($user_id)
    {
        $getacceptfollower  = UserFollowers::with('getUser', 'getUserFollower.getCategory')->where('user_id', $user_id)->where('status', 'accepted')->get();
        return response()->json(['success' => true, 'data' => $getacceptfollower]);
    }

    public function following(Request $req)
    {
        try {
            $input = $req->all();
            $validator = Validator::make($req->all(), [
                'user_id' => 'required',
                'following_id' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            unset($input['_token']);

            $userfollowing = UserFollowings::where('user_id', $input['user_id'])->where('following_id', $input['following_id'])->first();

            if ($userfollowing) {
                $userfollowing->delete();
                return response()->json(['success' => true, 'msg' => 'User UnFollowing Successfully']);
            } else {
                $userfollowing = UserFollowings::create($input);
                return response()->json(['success' => true, 'msg' => 'User Following Successfully', 'data' => $userfollowing]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getmyfollowing($user_id)
    {
        $getacceptfollower  = UserFollowings::with('getUser', 'getUserFollowing')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'data' => $getacceptfollower]);
    }
}
