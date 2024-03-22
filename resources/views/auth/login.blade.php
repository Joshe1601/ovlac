@extends('user.layout')

@section('content')



<div class="container">
    <div class="row justify-content-center">

            <div class="row col-md-8">
                <h1 class="text-center">Login your Account</h1>
            </div>

        <div class="row">
            @if (!empty($_GET['error']))
                <div class="col-md-12 alert alert-danger">
                    {{ $_GET['error'] }}
                </div>
            @endif
        </div>


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ controller_path() }}{{ controller_sep() }}md=auth&action={{ $form_action }}"
                          aria-label="{{ __('Login') }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control' }}"
                                       name="email" value="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control' }}"
                                       name="password" required>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
{{--        <div class="row col-md-8">--}}
{{--            <a href="{{ route('auth.forgot_password') }}">Forgot your password?</a>--}}
{{--        </div>--}}
    </div>

</div>


@endsection

