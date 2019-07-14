@extends('layouts.default')

@section('content')
 
  
<div class="row">
    <div class="col-md-8">
        <h1>Blog Posts</h1> <br>

        @if($posts->count() > 0)
            @foreach($posts as $post)
                <div class="container">
                        <div class="card mb-4" style="width: 30rem; height:25rem;">
                                <img class="card-img-top" src="{{ asset('images/posts/'. $post->photo) }}" alt="Card image cap">
                                <div class="card-body">
                                    <h2 class="card-title" style="color:blue;">
                                        
                                            {{ $post->title }}
                                        
                                    </h2>
                                    
                                    <div class="meta">
                                            <span class="badge badge-info">
                                                    <i class="fas fa-calendar"></i> {{ $post->created_at }}
                                            </span>
                                                &nbsp
                                            <span class="badge badge-primary">
                                                    <i class="fas fa-user"></i>  {{ $post->user_name }}
                                            </span>
                                    </div>
                                    
                                    <p class="card-text">
                                        {!! str_limit($post->body,50) !!}
                                    </p>
                                    <a class="btn btn-primary btn-xs" href="{{ url('/posts/' . $post->slug) }}">Read More</a>
                                </div>
                        </div>
                </div>
                    
        
            @endforeach
            {{ $posts->links() }}
        @else 
            <div class="alert alert-info">
                <strong>Ops</strong> No Posts
            </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Tags
            </div>
            <div class="card-body">
                @foreach ($tags as $tag)
                <a href="{{ route('tags.show', $tag->id) }}" class="btn btn-primary btn-sm">
                   
                          <i class="fa fa-tag"></i>{{ $tag->tag }}
                   
                 </a>
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection


