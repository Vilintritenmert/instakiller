@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-md-8">
                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <br>
                <div class="card">
                    <div class="card-header">Create New</div>
                    <div class="card-body">
                        <form action="{{route('dashboard.add')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="title" required placeholder="{{__('Title')}}"
                                           class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    @error('alt')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="alt" required placeholder="{{__('Hint')}}"
                                           class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    @error('img')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="file" name="image" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="form-control btn btn-success">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @foreach($posts as $post)
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-8">
                                    <a href="{{route('dashboard.post-edit-form', ['post' => $post->id ])}}">
                                        {{$post->title}}
                                    </a>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{route('dashboard.delete', ['post' => $post->id])}}" METHOD="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger form-control" >
                                            Delete Post
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body text-center" >
                            <img src="{{$post->file_url}}" alt="{{$post->alt}}" title="{{$post->alt}}" >
                        </div>
                    </div>
                @endforeach
                <br>
                {{ $posts->links() }}

            </div>
        </div>
    </div>
@endsection
