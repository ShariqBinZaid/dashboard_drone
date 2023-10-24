<?php

namespace App\Http\Controllers;

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
                'is_active' => 'required',
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
                $usersubcriptions = UserSubscriptions::create(['user_id' => Auth::user()->id, 'subscriptions_id' => $subscriptions->id]);
                return response()->json(['success' => true, 'msg' => 'Subscriptions Purchased Successfully', 'data' => $subscriptions]);
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
        $getcategories = Subscriptions::get();
        return response()->json(['success' => true, 'data' => $getcategories]);
    }

    public function usersubcriptions(Request $req)
    {
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
    }

    public function getusersubcriptions($user_id)
    {
        $getusersubcriptions = UserSubscriptions::with('userSubscriptions')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'data' => $getusersubcriptions]);
    }

    public function winners()
    {
        $winners = Winners::where('user_id', Auth::user()->id)->get();
        return response()->json(['success' => true, 'data' => $winners]);
    }

    // public function getpostsubscriptions($subscription_id)
    // {
    //     try {
    //         $getpostsubscriptions = PostSubscriptions::with('Subscriptions', 'Posts')->where('subscription_id', $subscription_id)->take(3)->get();

    //         if (!empty($getpostsubscriptions)) {
    //             foreach ($getpostsubscriptions as $k => $ps) {
    //                 $isLike = false;
    //                 if (UserLikes::where('user_id', Auth::id())->where('post_id', $ps->id)->exists()) {
    //                     $isLike = true;
    //                 }
    //                 $getpostsubscriptions[$k]->commentCount += UserComments::where('post_id', $ps->id)->count();
    //                 $getpostsubscriptions[$k]->likeCount += UserLikes::where('post_id', $ps->id)->count();
    //                 $getpostsubscriptions[$k]->isLike += $isLike;
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }

    //     return response()->json(['success' => true, 'data' => $getpostsubscriptions]);
    // }

    // public function getpostsubscriptions($subscription_id)
    // {
    //     $getpostsubscriptions = PostSubscriptions::with('Subscriptions')
    //         ->where('subscription_id', $subscription_id)
    //         ->withCount('likes')
    //         ->orderByDesc('likes_count')
    //         ->take(3)->get();

    //     if (!empty($getpostsubscriptions)) {
    //         foreach ($getpostsubscriptions as $k => $ps) {
    //             $isLike = false;
    //             if (UserLikes::where('user_id', Auth::id())->where('post_id', $ps->id)->exists()) {
    //                 $isLike = true;
    //             }
    //             $getpostsubscriptions[$k]->commentCount += UserComments::where('post_id', $ps->id)->count();
    //             // $getpostsubscriptions[$k]->likeCount += UserLikes::where('post_id', $fcu->id)->count();
    //             $getpostsubscriptions[$k]->isLike += $isLike;

    //             Winners::create([
    //                 'user_id' => Auth::id(),
    //                 'subscription_id' => $subscription_id,
    //                 'winner' => $k + 1,
    //                 'prize_type' => 'price',
    //             ]);
    //         }

    //         // Subscriptions::updated([
    //         //     'is_active' => 0
    //         // ]);
    //     }

    //     return response()->json(['success' => true, 'data' => $getpostsubscriptions]);
    // }

    public function getpostsubscriptions($subscription_id)
    {
        try {
            $getpostsubscriptions = PostSubscriptions::with('Subscriptions', 'Posts')
                ->where('subscription_id', $subscription_id)
                ->withCount('likes')
                ->orderByDesc('likes_count') // Order by likes_count in descending order
                ->take(3) // Take the top 3 results
                ->get();

            if (!$getpostsubscriptions->isEmpty()) {
                foreach ($getpostsubscriptions as $k => $ps) {
                    $isLike = UserLikes::where('user_id', Auth::id())->where('post_id', $ps->id)->exists();
                    $getpostsubscriptions[$k]->commentCount += UserComments::where('post_id', $ps->id)->count();
                    $getpostsubscriptions[$k]->isLike = $isLike;
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return response()->json(['success' => true, 'data' => $getpostsubscriptions]);
    }
}
