@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif

@section('content')
    <div class="container mx-auto px-4 py-2">
        <div>
            <h2 class="flex text-center mx-auto text-6xl px-8 py-4">{{ __('Create User') }}</h2>
        </div>

        <div class="row">
            @if (!empty($_GET['error']))
                <div class="col-md-12 alert alert-danger">
                    {{ $_GET['error'] }}
                </div>
            @endif
        </div>

        <div class="px-3 py-2 mb-3 ">
            <div class="mx-auto md:w-3/5">

                <form
                    method="POST"
                    action="{{ controller_path() }}{{ controller_sep() }}md=user&action={{ $form_action }}&api_token={{ $api_token }}"
                    aria-label="{{ __('Register') }}"
                    class="max-w-full sm:w-full mx-auto py-6"
                >
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="mail@mail.com" required />
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="********"
                            required />
                    </div>

                    <div class="form-check my-4">

                        <input class="form-check-input"
                               type="checkbox" value="1"
                               id="is_admin" name="is_admin"
                        />
                        <label class="form-check-label " for="is_admin">
                            Admin
                        </label>
                        <br />
                    </div>
                    <button
                        type="submit"
                        class="text-white bg-red-ovlac hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        {{ __('Save User') }}
                    </button>
                </form>


            </div>
        </div>

    </div>

@endsection

