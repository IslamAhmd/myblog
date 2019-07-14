@extends('layouts.default')

@section('content')
 
  
<div class="container">

    <h1>Posts Tagged {{ $tag->tag }}</h1> <br>

    
          @foreach($tag->posts as $post)
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
          
  
  </div>


@endsection


