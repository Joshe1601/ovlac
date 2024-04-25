@extends('layouts.main')

@section('content')

    <section class="d-flex justify-content-center align-items-center bg-white mt-5">
        <div class="mt-5 px-6 py-0 ">
            <div class="justify-center mt-5">
                <div class="row p-2">
                    @if (!empty($_GET['error']))
                        <div class="col-md-12 alert alert-danger">
                            {{ $_GET['error'] }}
                        </div>
                    @endif
                </div>
            </div>

               <div class="login-logo mt-5">
                   <a href="#" class="flex items-center mb-6 text-4xl m-4 p-2 mx-auto">
                       <img src="{{ relative_path() }}/public/images/ovlac/logo_ovlac_fondo_blanco.jpg" alt="Ovlac Logo" class="mx-auto text-center login-logo-img"/>
                   </a>
               </div>

            <div class="w-full bg-gray-50 rounded-lg shadow shadow-xl dark:border md:mt-0 rounded-xl">

                <div class="p-5 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        {{ tra('Login your account') }}
                    </h1>

                    <form method="POST" action="{{ controller_path() }}{{ controller_sep() }}md=auth&action={{ $form_action }}"
                          aria-label="{{ __('Login') }}" class="p-3">
                        <div class="m-2">
                            <label for="email"
                                   class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
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
                                placeholder="••••••••"
                                class="form-control m-1"
                                required>
                        </div>

                        <button
                            type="submit"
                            class="ovlac-button my-4"
                        >
                            Login
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

