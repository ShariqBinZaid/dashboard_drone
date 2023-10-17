<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Categories;
use App\Models\UserComments;
use Illuminate\Http\Request;
use App\Models\UserSubscriptions;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostsResource;
use App\Models\ReplyComments;
use App\Models\User;
use App\Models\UserLikes;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['posts'] = Posts::all();
        $data['categories'] = Categories::all();
        return view('posts.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $posts = Posts::with('getCategorys')->get();
        return new PostsResource($posts);
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
            'file' => 'required',
            'date' => 'required',
            'desc' => 'required',
            'category_id' => 'required',
            'post_type' => 'required',
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
            $posts = Posts::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Posts Updated Successfully.']);
        } else {
            $posts = Posts::create($input);
            return response()->json(['success' => true, 'msg' => 'Posts Created Successfully', 'data' => $posts]);
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
            $posts = Posts::all();
            return new PostsResource($posts);
        } else {
            $posts = Posts::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $posts]);
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
        Posts::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Posts Deleted Successfully']);
    }

    public function getposts()
    {
        $getpost = Posts::with('getUser', 'getCategorys')->get();

        if (!empty($getpost)) {
            foreach ($getpost as $k => $fcu) {
                $isLike = false;
                if (UserLikes::where('user_id', Auth::id())->where('post_id', $fcu->id)->exists()) {
                    $isLike = true;
                }
                $getpost[$k]->commentCount += UserComments::where('post_id', $fcu->id)->count();
                $getpost[$k]->likeCount += UserLikes::where('post_id', $fcu->id)->count();
                $getpost[$k]->isLike += $isLike;
            }
        }
        return response()->json(['success' => true, 'data' => $getpost]);
    }

    public function viewposts($id)
    {
        $viewposts = Posts::with('getUser')->where('id', $id)->get();
        return response()->json(['success' => true, 'data' => $viewposts]);
    }

    public function userpostlikes(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            // 'user_id' => 'required',
            'post_id' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input += ['user_id' => Auth::id()];

        unset($input['_token']);
        if (@$input['id']) {
            $posts = UserLikes::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Posts Liked Updated Successfully.']);
        } else {
            $posts = UserLikes::create($input);
            return response()->json(['success' => true, 'msg' => 'Posts Liked Successfully', 'data' => $posts]);
        }
    }

    public function getuserpostlikes($post_id)
    {
        $getpostlikes = UserLikes::where('post_id', $post_id)->get();
        return response()->json(['success' => true, 'data' => $getpostlikes]);
    }

    public function userlike(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'post_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $checkLike = UserLikes::where('user_id', $input['user_id'])->where('post_id', $input['post_id'])->get();
        if ($checkLike->count() > 0) {
            foreach ($checkLike as $check) {
                UserLikes::where('id', $check->id)->delete();
            }

            return response()->json(['success' => true, 'msg' => 'User UnLike Successfully', 'data' => []]);
        }

        $userlike = UserLikes::create($input);
        return response()->json(['success' => true, 'msg' => 'User Liked Successfully', 'data' => $userlike]);
    }

    public function likecheck($user_id, $post_id)
    {
        $likecheck = UserLikes::where('user_id', $user_id)->where('post_id', $post_id)->exists();

        if (!$likecheck) {
            return response()->json(['success' => true, 'msg' => 'User Not Like']);
        }

        return response()->json(['success' => true, 'msg' => 'User Already Liked']);
    }

    public function userpostcomments(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'post_id' => 'required',
            'comment' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input += ['user_id' => Auth::id()];

        unset($input['_token']);
        if (@$input['id']) {
            $posts = UserComments::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Comments Updated Successfully.']);
        } else {
            $posts = UserComments::create($input);
            $posts = UserComments::with('getUser')->get();
            return response()->json(['success' => true, 'msg' => 'User Comments Successfully', 'data' => $posts]);
        }
    }

    public function userreplycomments(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'comment_id' => 'required',
            'comment' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input += ['user_id' => Auth::id()];

        unset($input['_token']);

        if (@$input['id']) {
            $posts = ReplyComments::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Reply Comments Updated Successfully.']);
        } else {
            $posts = ReplyComments::create($input);
            $posts = ReplyComments::with('getUser')->get();
            return response()->json(['success' => true, 'msg' => 'User Reply Comments Successfully', 'data' => $posts]);
        }
    }

    public function getuserreplycomments($comment_id)
    {
        $getuserreplycomments = ReplyComments::with('getUser')->where('comment_id', $comment_id)->get();
        return response()->json(['success' => true, 'data' => $getuserreplycomments]);
    }

    public function getuserpostcomments($post_id)
    {
        $userpostcomments = UserComments::with('getUser', 'getPost')->where('post_id', $post_id)->get();
        return response()->json(['success' => true, 'data' => $userpostcomments]);
    }

    public function getusercomments()
    {
        $getpostcommentlike = UserComments::get();
        return response()->json(['success' => true, 'data' => $getpostcommentlike]);
    }
}
