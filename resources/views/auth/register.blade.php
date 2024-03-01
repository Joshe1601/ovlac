@extends('user.layout')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="row ">
                <h1>Create an Account</h1>

                <div class="row col-md-8">
                    <ul>
                        <li>Por favor introduzca un Email váido</li>
                        <li>La contraseña debe tener como mínimo 6 caracteres</li>
                    </ul>
                </div>
                <div class="row">
                    @if (!empty($_GET['registration_error']))
                        <div class="col-md-12 alert alert-danger">
                            {{ $_GET['registration_error'] }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.store') }}" aria-label="{{ __('Register') }}">

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
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row col-md-8">
                If you already have an account, <a href="{{ route('auth.login') }}">Login</a>
            </div>
        </div>
    </div>


@endsection

