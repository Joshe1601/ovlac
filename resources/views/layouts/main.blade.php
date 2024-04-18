<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">--}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>--}}
    <script src="https://cdn.tailwindcss.com"></script>
{{--    <script type="text/javascript" src="{{ relative_path() }}/public/js/back.js"></script>--}}
    <link rel="stylesheet" media="screen" type="text/css" href="{{ relative_path() }}/public/colorpicker/css/colorpicker.css" />
    <script type="text/javascript" src="{{ relative_path() }}/public/colorpicker/js/colorpicker.js"></script>
    <link rel="stylesheet" media="screen" type="text/css" href="{{ relative_path() }}/public/css/ovlac.css" />
    <title>Configurador 3D</title>
</head>
<body>
<header>


    <nav class="bg-red-ovlac border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ relative_path() }}/public/images/ovlac/logo_ovlac_fondo_rojo.jpg" alt="Ovlac Logo" class="h-12"/>
            </a>

            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-red-ovlac dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                    @if(isset($api_token))
                        <li>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=logout"
                                type="button"
                                class="py-2 px-3 text-white bg-red-ovlac md:text-white md:p-0 dark:text-white md:dark:text-white"
                            >
                                {{ tra("Logout") }}
                            </a>
                        </li>

                        <li>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}md=user&action=index&api_token={{ $api_token }}"
                                type="button"
                                class="block py-2 px-3 text-white bg-red-ovlac rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white"
                            >

                                {{ tra("Users") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}md=product&action=index&api_token={{ $api_token }}"
                                type="button"
                                class="block py-2 px-3 text-white bg-red-ovlac rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white"
                            >

                                {{ tra("Products") }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=login"
                                type="button"
                                class="block py-2 px-3 text-white bg-red-ovlac rounded md:bg-transparent md:text-white md:p-0 dark:text-white md:dark:text-white"
                            >
                                {{ tra("Login") }}
                            </a>
                        </li>
                    @endif


                </ul>
            </div>
        </div>
    </nav>


</header>

<div class="" id="main_3dp">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
