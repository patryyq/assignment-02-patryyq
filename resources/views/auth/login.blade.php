@extends('layouts.app')

@section('content')

<div class="col-12 d-flex justify-content-center">
    <form action="{{ route('authenticate') }}" method="POST" class="col-sm-12 col-md-6 d-flex flex-wrap flex-column justify-content-center">
        <h1 class="mx-0 mt-4">Login</h1>
        @csrf

        @if (session('status') && session('status')['status'] == 3)
        <div class="mt-3 alert alert-warning">{{ session('status')['message'] }}</div>
        @endif
        <div class="mt-3 form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="E-mail" class="form-control p-2 bg-gray-200 @error('email') is-invalid @enderror" />

            @error('email')
            <div class="mt-3 alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-3 form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control p-2 bg-gray-200 @error('password') is-invalid @enderror" />

            @error('password')
            <div class="mt-3 alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-primary">Login</button>
        <div class="d-flex flex-wrap flex-row justify-content-between">
            <a href="/register"> <button type="button" class="mt-3 btn btn-danger">Register</button></a>
            <a href="/forgot-password"> <button type="button" class="mt-3 btn btn-secondary">Forgot password?</button></a>
        </div>
    </form>
</div>

@endsection