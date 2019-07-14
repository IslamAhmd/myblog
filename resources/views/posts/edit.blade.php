@extends('layouts.default')

@section('content')
     
    <h1>Edit {{ $post->title }}</h1>
    <hr>

    {!! Form::open( ['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'] ) !!}

        {{ Form::hidden('_method', 'PUT') }}

        <div class="form-group">
            {{ Form::label('Title') }}
            {{ Form::text('title', $post->title , ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('Body') }}
            {{ Form::textarea('body', $post->body , ['class' => 'form-control ckeditor']) }}
        </div>

        <div class="form-group">
                {{ Form::label('Tags') }}
                <select name="tags[]" class="form-control tags" multiple>
                    @foreach($tags as $tag)
                      <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                    @endforeach
                </select>
        </div>

        <div class="form-group">
            {{ Form::label('Featured Image') }}
            {{ Form::file('photo', ['placeholder' => 'Enter Featured Image', 'class' => 'form-control']) }}
        </div>

        <div class="form-group float-right">
            {{ Form::submit('Update', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}
@endsection

@section('javascript')
  <script>
       $(document).ready(function() {
          $('.tags').select2().val({!! $post->tags()->pluck('id') !!}).trigger('change');
       });
  </script>
@endsection