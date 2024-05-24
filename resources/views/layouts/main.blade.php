<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
{{--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>



    <style>{!! include (base_path() . '/public/css/back.css') !!}</style>
    <style>{!! include (base_path() . '/public/css/ovlac.css') !!}</style>
    <script type="text/javascript" src="{{ relative_path() }}/public/js/back.js"></script>
    <link rel="stylesheet" media="screen" type="text/css" href="{{ relative_path() }}/public/colorpicker/css/colorpicker.css" />

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
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css"
        rel="stylesheet"
    />

    <script type="text/javascript" src="{{ relative_path() }}/public/colorpicker/js/colorpicker.js"></script>
    <title>Configurador 3D</title>
</head>
<body>

<header>

    <div class="d-flex flex-column flex-md-row align-items-center p-2 px-md-4 mb-2 bg-red-ovlac">
        <h5 class="my-0 mr-md-auto font-weight-small">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ relative_path() }}/public/images/ovlac/Logo.png" alt="Ovlac Logo" class="h-10" style="width: 200px"/>
            </a>
        </h5>
        <nav class="my-2 my-md-0 mr-md-3">
            @if(isset($api_token))

                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=logout"
                        type="button"
                        class="py-2 px-3 text-white bg-red-ovlac px-4 hover:bg-red-700 hover:rounded-xl fs-5"
                    >
                        {{ tra("Logout") }}
                    </a>



                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}md=user&action=index&api_token={{ $api_token }}"
                        type="button"
                        class="block py-2 px-3 text-white bg-red-ovlac rounded-xl px-4 hover:bg-red-700 hover:rounded-xl fs-5"
                    >
                        {{ tra("Users") }}
                    </a>

                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}md=product&action=index&api_token={{ $api_token }}"
                        type="button"
                        class="block py-2 px-3 text-white bg-red-ovlac rounded-xl fs-5"
                    >

                        {{ tra("Products") }}
                    </a>

            @else

                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=login"
                        type="button"
                        class="block py-2 px-3 text-white bg-red-ovlac rounded-xl fs-5"
                    >
                        {{ tra("Login") }}
                    </a>

            @endif
        </nav>
    </div>


</header>

<div class="" id="main_3dp">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
