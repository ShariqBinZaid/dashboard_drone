<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Categories;
use App\Models\UserComments;
use Illuminate\Http\Request;
use App\Models\UserSubscriptions;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostsResource;
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
        $getpots = Posts::with('getUser')->get();
        return response()->json(['success' => true, 'data' => $getpots]);
    }

    public function getpostscomments()
    {
        $getpostscomments = Posts::with('getUser', 'comments','likes')->get();
        return response()->json(['success' => true, 'data' => $getpostscomments]);
    }

    public function usercomments(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'comment' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input += ['user_id' => Auth::id()];
        unset($input['_token']);
        if (@$input['id']) {
            $usercomments = UserComments::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Comments Updated Successfully.']);
        } else {
            $usercomments = UserComments::create($input);
            return response()->json(['success' => true, 'msg' => 'User Comments Created Successfully', 'data' => $usercomments]);
        }
    }

    public function getusercomments($comment_id)
    {
        $usercomments = UserComments::with('getUser')->where('comment_id', $comment_id)->get();
        return response()->json(['success' => true, 'data' => $usercomments]);
    }
}
