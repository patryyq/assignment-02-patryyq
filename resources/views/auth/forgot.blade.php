@extends('layouts.app')

@section('content')

<div class="col-12 d-flex justify-content-center">

    @if (session('status') && session('status')['status'] == 1)
    <div class="col-sm-12 col-md-6 d-flex flex-wrap flex-column justify-content-center">
        <h1 class="mx-0 mt-4">Reset link</h1>
        Click on the link below to access a form to change your password.
        <div class="mt-3 alert alert-warning"><a href="{{ session('status')['message'] }}">Reset link</a></div>
        <div class="mt-3 p-0 lert alert-light" role="alert">
            Note: this page is used as a replacement for an email. It is difficult to send emails in localhost, so I decided to do something like this.
        </div>
    </div>
    @elseif (isset($status) && $status == 2)
    <form action="{{ url()->current() }}" method="POST" class="col-sm-12 col-md-6 d-flex flex-wrap flex-column justify-content-center">
        @csrf
        <h1 class="mx-0 mt-4">Set a new password</h1>
        <div class="mt-3 form-group">
            <label for="password">New password:</label>
            <input type="text" name="password" id="password" placeholder="New password" class="form-control p-2 bg-gray-200 @error('email') is-invalid @enderror" />

            <label class="mt-3" for="password_confirmation">Repeat new password:</label>
            <input type="text" name="password_confirmation" id="password_confirmation" placeholder="Repeat new password" class="form-control p-2 bg-gray-200 @error('email') is-invalid @enderror" />
            @error('password')
            <div class="mt-3 alert alert-danger">{{ $message }}</div>
            @enderror
            @error('password_confirmation')
            <div class="mt-3 alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-primary">Set new password</button>
    </form>
    @else
    <form action="{{ route('forgot-pw') }}" method="POST" class="col-sm-12 col-md-6 d-flex flex-wrap flex-column justify-content-center">
        @csrf
        <h1 class="mx-0 mt-4">Forgot password</h1>
        <div class="mt-3 form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="E-mail" class="form-control p-2 bg-gray-200 @error('email') is-invalid @enderror" />

            @error('email')
            <div class="mt-3 alert alert-danger">{{ $message }}</div>
            @enderror

            @if (session('status') && session('status')['status'] == 0)
            <div class="mt-3 alert alert-danger">{{ session('status')['message'] }}</div>
            @endif
        </div>

        <button type="submit" class="mt-3 btn btn-primary">Send reset link</button>
        <div class="d-flex flex-wrap flex-row justify-content-between">
            <a href="/register"> <button type="button" class="mt-3 btn btn-danger">Register</button></a>
            <a href="/login"> <button type="button" class="mt-3 btn btn-secondary">Login</button></a>
        </div>

    </form>
    @endif
</div>

@endsection