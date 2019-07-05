@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update</div>
                    <div class="card-body">
                        <form action="{{route('dashboard.update', ['id' => $post->id])}}"
                              enctype="multipart/form-data"  method="POST" >
                            @csrf

                            <div class="row">
                                <div class="col-sm-4">
                                    @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="title" required class="form-control"
                                           value="{{ old('title' ,$post->title) }}" placeholder="{{__('Title')}}">
                                </div>
                                <div class="col-sm-4">
                                    @error('alt')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="alt" class="form-control"
                                           required value="{{ old('alt', $post->alt) }}"
                                           placeholder="{{__('Title')}}"
                                    >
                                </div>
                                <div class="col-sm-4">
                                    @error('img')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="file" name="image">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <img src="{{$post->file_url}}" alt="{{$post->alt}}" title="{{$post->alt}}">
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="form-control btn btn-success">Update</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
