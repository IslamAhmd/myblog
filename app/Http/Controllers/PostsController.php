<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Tag;
use Image;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // every request needs to be authenticated
        // $this->middleware('auth');

        // only the specified needs to be authenticated
        // $this->middleware('auth', ['only' => ['show'] ]);

        // all need to be authenticated except the specified
        $this->middleware('auth', ['except' => ['index','show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        $tags = Tag::all();
        return view('posts.index', compact('posts','tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
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
          'body' => 'required',
          'photo' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Current User
        $user = Auth::user();

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $now = date('YmdHms');
        $post->slug = str_slug($post->title) . '-' . $now;
        $post->user_id = $user->id;
        $post->user_name = Auth::user()->name;

        //upload the Featured Image
        if($request->hasFile('photo')){

            $photo = $request->file('photo');
            $filename = time().'-'. $photo->getClientOriginalName();
            $location = public_path('images/posts/'. $filename);

            // the above structions are the standared , the next are using image intervention
            Image::make($photo)->resize(200, 200)->save($location);
            $post->photo = $filename;
        }


        $post->save();

        $post->tags()->sync($request->tags);

        return redirect('/posts')->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug',$slug)->first();
        return view('posts.show', compact('post'));
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
