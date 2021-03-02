<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // public function __construct(){

    //     $this->middleware('auth');
    // }


    public function index(){

        $posts =Post::latest()->with(['user','likes'])->get();
        return view('posts.index',[

            'posts' =>$posts
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[

            'body' =>'required'
        ]);
        $request->user()->posts()->create([
            'body' =>$request->body
        ]);

        // $request->user()->posts()->create($request->only('body'));
        return back();
    }
    public function destroy(Post $post){

        // if(!$post->ownedBy(auth()->user())){
        //     dd('no');
        // }
        $this->authorize('delete',$post);
        $post->delete();
        return back();
    }
}
