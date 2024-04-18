<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">--}}
{{--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>--}}
    <title>Configurador 3D</title>
</head>
<body>
<header>

{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">--}}

{{--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <!-- MDB -->
{{--    <link--}}
{{--        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css"--}}
{{--        rel="stylesheet"--}}
{{--    />--}}


    {{-- <link href="css/back.css" rel="stylesheet"> --}}
{{--    <style>{!! include (base_path() . '/public/css/back.css') !!}</style>--}}

    <!-- MDB -->
{{--    <script--}}
{{--        type="text/javascript"--}}
{{--        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"--}}
{{--    ></script>--}}


    <script type="text/javascript" src="{{ relative_path() }}/public/js/back.js"></script>
    <link rel="stylesheet" media="screen" type="text/css" href="{{ relative_path() }}/public/colorpicker/css/colorpicker.css" />
    <script type="text/javascript" src="{{ relative_path() }}/public/colorpicker/js/colorpicker.js"></script>
    <link rel="stylesheet" media="screen" type="text/css" href="{{ relative_path() }}/public/css/ovlac.css" />





<nav class="bg-red-ovlac border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
        <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ relative_path() }}/public/images/ovlac/logo_ovlac_fondo_rojo.jpg" alt="Ovlac Logo" class="h-12"/>
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">

            </span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                @if(isset($api_token))
                    <li>
                        <a
                            href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=logout"
                            type="button"
                            class="nav-link text-white"
                        >
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                            {{ tra("Logout") }}
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ controller_path() }}{{ controller_sep() }}md=user&action=index&api_token={{ $api_token }}"
                            type="button"
                            class="nav-link text-white"
                        >
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                            {{ tra("Users") }}
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ controller_path() }}{{ controller_sep() }}md=product&action=index&api_token={{ $api_token }}"
                            type="button"
                            class="nav-link text-white"
                        >
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                            {{ tra("Products") }}
                        </a>
                    </li>
                @else
                    <li>
                        <a
                            href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=login"
                            type="button"
                            class="nav-link text-white"
                        >
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                            {{ tra("Login") }}
                        </a>
                    </li>
                @endif


            </ul>
        </div>
    </div>
</nav>

{{--<div class="px-3 py-2 text-bg-dark">--}}
{{--        <div class="container">--}}
{{--            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">--}}
{{--                <a href="{{ controller_path() }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">--}}
{{--                    <img src="{{ relative_path() }}/public/images/icon.png" />--}}
{{--                </a>--}}

{{--                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">--}}

{{--                @if(isset($api_token))--}}
{{--                    <li>--}}
{{--                        <a--}}
{{--                            href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=logout"--}}
{{--                            type="button"--}}
{{--                            class="nav-link text-white"--}}
{{--                        >--}}
{{--                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>--}}
{{--                            {{ tra("Logout") }}--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a--}}
{{--                            href="{{ controller_path() }}{{ controller_sep() }}md=user&action=index"--}}
{{--                            type="button"--}}
{{--                            class="nav-link text-white"--}}
{{--                        >--}}
{{--                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>--}}
{{--                            {{ tra("Users") }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a--}}
{{--                            href="{{ controller_path() }}{{ controller_sep() }}md=product&action=index&api_token={{ $api_token }}"--}}
{{--                            type="button"--}}
{{--                            class="nav-link text-white"--}}
{{--                        >--}}
{{--                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>--}}
{{--                            {{ tra("Products") }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @else--}}
{{--                    <li>--}}
{{--                        <a--}}
{{--                            href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=login"--}}
{{--                            type="button"--}}
{{--                            class="nav-link text-white"--}}
{{--                        >--}}
{{--                            <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>--}}
{{--                            {{ tra("Login") }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--               @endif--}}



{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

</header>

   <div class="flex md:flex-1">
       @yield('content')
   </div>


</body>
</html>
