@extends('layouts.app')

@section('content')
    <div class="col-12 d-flex justify-content-center">
        @if (!session('status') || session('status')['status'] != 1)
            <form action="{{ route('authenticate') }}" method="POST"
                class="col-xs-12 col-md-8 col-xl-6 d-flex flex-wrap flex-column justify-content-center">
                <h1 class="mx-0 mt-4">Login</h1>
                @csrf
                @if (session('status') && session('status')['message'] && session('status')['status'] != 3)
                    <div class="mt-3 alert alert-danger">{{ session('status')['message'] }}</div>
                @endif
                @if (session('status') && session('status')['status'] == 3)
                    <div class="mt-3 alert alert-warning">{{ session('status')['message'] }}</div>
                @endif
                <div class="mt-3 form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" placeholder="E-mail"
                        class="form-control p-2 bg-gray-200 @error('email') is-invalid @enderror" />

                    @error('email')
                        <div class="mt-3 alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password"
                        class="form-control p-2 bg-gray-200 @error('password') is-invalid @enderror" />

                    @error('password')
                        <div class="mt-3 alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="mt-3 btn btn-primary">Login</button>
                <div class="d-flex flex-wrap flex-row justify-content-between">
                    <a href="/register"> <button type="button" class="mt-3 btn btn-outline-danger">Register</button></a>
                    <a href="/forgot-password"> <button type="button" class="mt-3 btn btn-outline-secondary">Forgot
                            password?</button></a>
                </div>
            </form>
        @else
            <form action="{{ route('2fa') }}" method="POST"
                class="col-xs-12 col-md-8 col-xl-6 d-flex flex-wrap flex-column justify-content-center">
                <h1 class="mx-0 mt-4">2FA Verification</h1>
                @csrf

                <div class="mt-3 form-group">
                    <div class="mt-3 alert alert-warning">
                        Current code sent to 'email': <b>{{ session('status')['code'] }}</b></div>
                    <label for="twofa" class="mt-2">2FA code:</label>
                    <input type="text" name="twofa" id="twofa" placeholder="Type the 2FA code here..."
                        class="form-control p-2 bg-gray-200 @error('2fa') is-invalid @enderror" />
                    <input type="text" hidden name="email" id="email" value="{{ session('status')['req']['email'] }}" />
                    <input type="text" hidden name="password" id="password"
                        value="{{ session('status')['req']['password'] }}" />
                </div>
                <button type="submit" class="mt-3 btn btn-primary">Submit 2FA code</button>
                <div class="d-flex flex-wrap flex-row justify-content-between">
                    <a href="/register"> <button type="button" class="mt-3 btn btn-outline-danger">Register</button></a>
                    <a href="/forgot-password"> <button type="button" class="mt-3 btn btn-outline-secondary">Forgot
                            password?</button></a>
                </div>
                <div class="mt-4 p-0 lert alert-light" role="alert">
                    Note: Similarly to 'forgot a password' feature, I decided to display codes here, because its difficult
                    to send emails in localhost.
                </div>
            </form>
        @endif
    </div>
@endsection
