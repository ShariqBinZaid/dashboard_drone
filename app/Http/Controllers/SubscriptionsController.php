<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Carbon\Carbon;
use App\Models\Winners;
use App\Models\UserLikes;
use App\Models\UserComments;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\UserFollowers;
use App\Models\PostSubscriptions;
use App\Models\UserSubscriptions;
use Illuminate\Support\Facades\Auth;
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
        try {
            $input = $req->all();

            $validator = Validator::make($input, [
                'image' => 'required',
                'name' => 'required',
                'price' => 'required',
                'desc' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                // 'is_active' => 'required',
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
                return response()->json(['success' => true, 'msg' => 'Subscriptions Submitted Successfully', 'data' => $subscriptions]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
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
            $subscriptions = Subscriptions::all();
            return new SubscriptionsResource($subscriptions);
        } else {
            $subscriptions = Subscriptions::where('id', $id)->first();
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
        Subscriptions::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Subscriptions Deleted Successfully']);
    }

    public function getsubscriptions()
    {
        $getcategories = Subscriptions::where('start_date', '<', Carbon::now()->format('Y-m-d'))->first();
        return response()->json(['success' => true, 'data' => $getcategories]);
    }

    public function usersubscriptions(Request $req)
    {
        try {
            $input = $req->all();

            $validator = Validator::make($input, []);

            // dd($input);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);
            if (@$input['id']) {
                $usersubcriptions = UserSubscriptions::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'User Subscriptions Updated Successfully.']);
            } else {
                $usersubcriptions = UserSubscriptions::create($input);
                return response()->json(['success' => true, 'msg' => 'User Subscriptions Created Successfully', 'data' => $usersubcriptions]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getusersubcriptions($user_id)
    {
        $getusersubcriptions = UserSubscriptions::with('userSubscriptions')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'data' => $getusersubcriptions]);
    }

    public function postsubscriptions(Request $req)
    {
        try {
            $input = $req->all();

            $validator = Validator::make($input, []);

            // dd($input);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);

            if (@$input['id']) {
                $postubscriptions = PostSubscriptions::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'Post Subscriptions Updated Successfully.']);
            } else {
                $postubscriptions = PostSubscriptions::create($input);
                return response()->json(['success' => true, 'msg' => 'Post Subscribed Successfully', 'data' => $postubscriptions]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getpostsubscriptions($id)
    {
        $getpostsubscriptions = Posts::with('getUser', 'getCategorys')->whereHas('subscriptions', function ($q) use ($id) {
            $q->where('id', $id);
        })->get();

        if (!empty($getpostsubscriptions)) {
            foreach ($getpostsubscriptions as $k => $ps) {
                $isLike = false;
                if (UserLikes::where('user_id', Auth::id())->where('post_id', $ps->id)->exists()) {
                    $isLike = true;
                }
                $getpostsubscriptions[$k]->commentCount += UserComments::where('post_id', $ps->id)->count();
                $getpostsubscriptions[$k]->likeCount += UserLikes::where('post_id', $ps->id)->count();
                $getpostsubscriptions[$k]->isLike += $isLike;
            }
        }

        return response()->json(['success' => true, 'data' => $getpostsubscriptions]);
    }

    public function subscriptionscheck($user_id, $subscriptions_id)
    {
        try {
            $subscriptionscheck = UserSubscriptions::where('user_id', $user_id)->where('subscriptions_id', $subscriptions_id)->exists();

            if (!$subscriptionscheck) {
                return response()->json(['success' => true, 'msg' => 'User Not Subscribed']);
            }

            return response()->json(['success' => true, 'msg' => 'User Already Subscribed', 'data' => $subscriptionscheck]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function counterstart($id)
    {
        try {
            $subscription = Subscriptions::find($id);
            $remainingTime = $subscription->getTimeRemaining();

            $days = $remainingTime['days'];
            $hours = $remainingTime['hours'];
            $minutes = $remainingTime['minutes'];
            $seconds = $remainingTime['seconds'];

            return response()->json(['success' => true, 'msg' => 'User Not Subscribed', 'days' => $days]);


            // dd($counter);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function winners($subscriptions_id)
    {
        $winners = Winners::where('subscriptions_id', $subscriptions_id)->take(3)->get();
        return response()->json(['success' => true, 'data' => $winners]);
    }
}
