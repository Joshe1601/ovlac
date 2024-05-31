@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif

@section('content')
    <div class="container mx-auto px-4 py-2">
        <div>
            <h2 class="flex text-center mx-auto text-6xl px-8 py-4">{{ tra('Update User') }}</h2>
        </div>

        <div class="row">
            @if (!empty($_GET['error']))
                <div class="col-md-12 alert alert-danger">
                    {{ $_GET['error'] }}
                </div>
            @endif
        </div>

        <div class="px-3 py-2 mb-3 ">
            <div class="mx-auto col-md-8 col-sm-12">

                <form
                    method="POST"
                    action="{{ controller_path() }}{{ controller_sep() }}md=user&user_id={{$user->id}}&action={{ $form_action }}@if ($user->id)&id={{$user->id}}@endif&api_token={{ $api_token }}"
                    aria-label="{{ __('Register') }}"
                    class="max-w-full sm:w-full mx-auto py-6"
                >
                    <div class="m-2">
                        <label for="email"
                               class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ $user->email }}"
                            placeholder="name@company.com" required>
                    </div>
                    <div class="m-2">
                        <label for="password"
                               class="form-label"
                        >Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control m-1"
                            required>
                    </div>
                    <div class="form-check my-4">
                        <input class="form-check-input"
                               type="checkbox" value="1"
                               {{ $user->is_admin == 1 ? "checked" : ''}}
                               id="is_admin" name="is_admin"
                        />
                        <label class="form-check-label " for="is_admin">
                            Admin
                        </label>
                    </div>
                    <button
                        type="submit"
                        class="ovlac-button my-4">
                        {{ tra('Update User') }}
                    </button>
                </form>
            </div>
        </div>
    </div>


@endsection


