@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <h1 class="text-center p-4">Create User</h1>


                <div class="row">
                    @if (!empty($_GET['error']))
                        <div class="col-md-12 alert alert-danger">
                            {{ $_GET['error'] }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ controller_path() }}{{ controller_sep() }}md=user&action={{ $form_action }}&api_token={{ $api_token }}"
                              aria-label="{{ __('Register') }}">


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

                            <div class="form-check col-md-6 offset-md-4">

                                <input class="form-check-input"
                                       type="checkbox" value="1"
                                       id="is_admin" name="is_admin"
                                />
                                <label class="form-check-label" for="is_admin">
                                    Admin
                                </label>
                                <br />
                            </div>




                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save User') }}
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

