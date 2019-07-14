@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard
                    <div class="btn-group float-right btn btn-light btn-sm">
                       <a href="{{ route('posts.create') }}">
                        <i class="fas fa-plus"></i> New Post
                       </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Your posts</h3>
                    <table class="table table-striped">
                        <thead>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>
                                        <a href="{{ url('/posts/' . $post->id . '/edit') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i> Edit Post
                                        </a>
                                    </td>
                                    <td>
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                            <button class="btn btn-danger btn-sm" type="submit">
                                              <i class="fas fa-trash-alt"></i>  Delete Post
                                            </button>
                                         {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
