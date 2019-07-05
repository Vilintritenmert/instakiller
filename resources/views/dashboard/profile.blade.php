@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        API Token: {{$profile->api_token}}
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">Details</div>
                    <div class="card-body">
                        <form action="{{route('dashboard.profile-update')}}" method="POST" >
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    @error('first_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                        <input type="text" name="first_name" required
                                               class="form-control"
                                               value="{{ old('first_name' ,$profile->first_name) }}">
                                </div>

                                <div class="col-sm-6">
                                    @error('last_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                        <input type="text" class="form-control"
                                               name="last_name" required value="{{ old('last_name', $profile->last_name) }}">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success form-control">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
