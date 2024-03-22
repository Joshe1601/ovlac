@extends('user.layout')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="row ">
                <h1>Reset your Password</h1>

                <div class="row col-md-8">
                    <ul>
                        <li>Please enter a valid Email</li>
                    </ul>
                </div>
                <div class="row">
                    @if (!empty($_GET['resetpassword_error']))
                        <div class="col-md-12 alert alert-danger">
                            {{ $_GET['resetpassword_error'] }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.send_email_link') }}" aria-label="{{ __('Reset Password') }}">

                            <div class="form-group
                            row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
