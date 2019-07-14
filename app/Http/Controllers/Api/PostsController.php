<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Http\Resources\PostResource;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        return PostResource::collection($posts);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [

          'title' => 'required|min:3',
          'body' => 'required'
        ]);

       

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $now = date('YmdHms');
        $post->slug = str_slug($post->title) . '-' . $now;
        $post->user_id = 1;



        $post->save();

        return new PostResource($post);

        
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
       
        $post = Post::where('slug',$slug)->firstOrFail();
        
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Current User
        $userId = Auth::id();
        if($post->user_id !== $userId)
        {
            return redirect('/posts')->with('error','This is not your Post');
        }

        $tags = Tag::all();

        return view('posts.edit', compact('post','tags'));
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
        

        $this->validate($request, [

            'title' => 'required|min:3',
            'body' => 'required',
            'photo' => 'required|mimes:jpeg,png,jpg|max:2048'
          ]);
  
  
          $post = Post::find($id);
          $post->title = $request->input('title');
          $post->body = $request->input('body');

          // Current User
        $userId = Auth::id();
        if($post->user_id !== $userId)
        {
            return redirect('/posts')->with('error','This is not your Post');
        }

        if($request->hasFile('photo')){

            $photo = $request->file('photo');
            $filename = time().'-'.$photo->getClientOriginalName();
            $location = public_path('images/posts/'.$filename);

            Image::make($photo)->resize(200,200)->save($location);
            $post->photo = $filename;
        }

          $post->save();

          $post->tags()->sync($request->tags);
  
          return redirect('/posts/'. $post->slug)->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Current User
        $userId = Auth::id();
        if($post->user_id !== $userId)
        {
            return redirect('/posts')->with('error','This is not your Post');
        }
        
        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted Successfully');
    }
}
