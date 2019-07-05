@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center"><h2>Instagram Killer</h2></div>
                </div>
                @foreach($posts as $post)
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-12 text-center">
                                    {{$post->title}}
                                </div>
                            </div>
                        </div>

                        <div class="card-body text-center">
                            <img src="{{$post->file_url}}" alt="{{$post->alt}}" title="{{$post->alt}}">
                        </div>
                    </div>
                @endforeach
                <br>
                {{ $posts->links() }}

            </div>
        </div>
    </div>
@endsection
