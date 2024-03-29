<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;

class CommentsController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }


    public function store(Request $request, $slug){

        $request->validate([
          
            'body' => 'required|min:5|max:500'
        ]);

        // post
        $post = Post::where('slug', $slug)->firstOrFail();

        // current user
        $userId = Auth::id();

        // comment
        $comment = new Comment;
        $comment->body = $request->input('body');
        $comment->post()->associate($post);
        $comment->user_id = $userId;
        $comment->save();

        return redirect()->route('posts.show', $slug)->with('success', 'Comment Added Successfully');
        
    }
}
