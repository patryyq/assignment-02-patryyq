@extends('layouts.app')


@section('content')

<div class="col-12 d-flex justify-content-center">
    <form action="{{ route('registration') }}" method="POST" class="col-xs-12 col-md-6 d-flex flex-wrap flex-column justify-content-center">
        <h1 class="mx-0 mt-4">Register</h1>
        @csrf
        <div class="mt-3 form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control p-2 bg-gray-200 @error('username') is-invalid @enderror" />

            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mt-3 form-group col-12">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" class="col-12 form-control p-2 bg-gray-200 @error('email') is-invalid @enderror" />

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-3 form-group">
            <label for="password">Password:</label>
            <input name="password" id="password" class="form-control p-2 bg-gray-200 @error('password') is-invalid @enderror" />

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-danger">Register</button>
        <a href="/login"> <button type="button" class="mt-3 btn btn-primary">Login</button></a>
    </form>
</div>

@endsection