@extends('layouts.main')

@section('content')



    <section class="container mx-auto bg-white">

        <div class="flex flex-col items-center justify-center px-6 py-0 mx-auto md:h-screen lg:py-0">
            <div class="justify-center">
                <div class="row p-2">
                    @if (!empty($_GET['error']))
                        <div class="col-md-12 alert alert-danger">
                            {{ $_GET['error'] }}
                        </div>
                    @endif
                </div>
            </div>

                <a href="#" class="flex items-center mb-6 text-4xl font-semibold text-gray-900 dark:text-white m-4 p-2 mx-auto">
                    <img src="{{ relative_path() }}/public/images/ovlac/logo_ovlac_fondo_blanco.jpg" alt="Ovlac Logo" class="h-12"/>
                </a>
            <div class="w-full bg-gray-50 rounded-lg shadow shadow-xl dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 ">


                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Entre a su cuenta
                    </h1>
                    <form method="POST" action="{{ controller_path() }}{{ controller_sep() }}md=auth&action={{ $form_action }}"
                          aria-label="{{ __('Login') }}">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>

                        <button
                            type="submit"
                            class="w-full text-white mt-4 bg-red-ovlac hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Login
                        </button>
{{--                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">--}}
{{--                            Don’t have an account yet? <a href="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>--}}
{{--                        </p>--}}
                    </form>
                </div>
            </div>
        </div>
    </section>




@endsection

