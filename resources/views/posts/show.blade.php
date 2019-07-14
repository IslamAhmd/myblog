@extends('layouts.default')

@section('content')


    <div class="row">
     
            <div class="col-sm-8">
                    <h1>{{ $post->title }}</h1><br>
        
                    <div>    
                        <img src="{{ asset('images/posts/'. $post->photo) }}" class="img-fluid rounded mx-auto d-block"><br><br>
                        <div class="container">
                            {!! $post->body !!}
                
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('tags.show', $tag->id) }}">
                                  <span class="badge badge-info">
                                    <i class="fa fa-tag"></i>{{ $tag->tag }}
                                  </span>
                                </a>
                                  &nbsp;   
                            @endforeach
                        </div>
                    </div>
                    <br>
        
                    <h4>Comments: {{ $post->comments()->count() }}</h4>
        
                    <ul class="comments">
        
                        @foreach($post->comments as $comment)
                            <li class="comment">
                                <hr>
                                <div class="clearfix">
                                    <h4 class="float-left">{{ $comment->user->name }}</h4>
                                    <p class="float-right">{{ $comment->created_at->format('d M Y') }}</p>
                                </div>
                
                                <p>{{ $comment->body }}</p>
                            </li>
                        @endforeach
            
                    </ul>
        
                    <div class="card">
                            <div class="card-header">
                                Add Your Comments
                            </div>
                
                            <div class="card-body">
                
                                @guest
                                    <div class="alert alert-info">Please Login To Comment</div>
                                @else
                                    <form action="{{ route('comments.store', $post->slug) }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="comment">Comment</label>
                                            <textarea name="body" placeholder="Add Your Comment" class="form-control" cols="10" rows="10"></textarea>
                                        </div>
                
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary">Add Comment</button>
                                        </div>
                                    </form>
                                @endguest
                            </div>
                    </div>
        
            </div>
      
            <div class="col-sm-4">
                @if(!Auth::guest() && ($post->user_id == Auth::user()->id) )
                    <div class="card" style="height:12rem;">
                        <div class="card-header" style="background-color:#2F4F4F;">
                            <i class="fas fa-cog"></i> Manage
                        </div>
                        <div class="card-body">

                            <ul class="listgroup">
                                <li class="list-group-item">
                                    <a href="{{ url('/posts/' . $post->id . '/edit') }}">
                                        <i class="fas fa-edit"></i> Edit Post
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                            <button type="submit">
                                                 <i class="fas fa-trash-alt"></i> Delete Post
                                            </button>
                                        {!! Form::close() !!}
                                    
                                </li>
                            </ul>
                                                                                      
                        </div>
                    </div> 
                @endif 
            </div>
    </div> 
     
@endsection

