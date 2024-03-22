@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <h1 class="text-center p-4">Update User</h1>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update User') }}</div>

                    <div class="card-body">
                        <form method="POST"
                              action="{{ controller_path() }}{{ controller_sep() }}md=user&user_id={{$user->id}}&action={{ $form_action }}@if ($user->id)&id={{$user->id}}@endif&api_token={{ $api_token }}"
                              aria-label="{{ __('Update') }}">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control' }}"
                                           name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control' }}"
                                           name="password">
                                </div>
                            </div>

                            <div class="form-check col-md-6 offset-md-4">

                                <input
                                    type="checkbox" value="1" class="form-check-input"
                                    {{ $user->is_admin == 1 ? "checked" : ''}}
                                    id="is_admin" name="is_admin" >
                                <label for="is_admin">Admin</label>
                                <br />
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update User') }}
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


