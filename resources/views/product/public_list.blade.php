{{--@if(isset($api_token))--}}
{{--@extends('layouts.public_main', ['api_token' => $api_token, 'is_admin' => $is_admin])--}}
@extends('layouts.public_main')
{{--@endif--}}

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">

        <div class="row mx-auto text-center m-5">
            <div>
                <h1 class="col-md-12 mx-auto">
                    <img src="{{ relative_path() }}/public/images/ovlac/Logo.png" alt="Ovlac Logo" class="" style="max-width: 400px"/>
                </h1>
            </div>
        </div>
    </div>
</div>


<div class="py-5 ml-md-5 pl-md-5">
    <div class="container">

        <div class="d-flex flex-md-row flex-sm-column my-5 ">
            <div class="row x-space-3">
            @foreach ($products as $product)
                    <div class="col-md-5 public-list-button mx-3">
                        <div class="mb-4 ">
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}action=show&module=product&id={{ $product->id }}"
                                target="_blank"
                                type="button"
                                class="py-2  "
                                data-mdb-ripple-color="dark"
                            >
                                <img src="{{ relative_path() }}{{ $product->image }}" alt="" class="card-img-top">
                            </a>
                        </div>

                    </div>
            @endforeach
            </div>
        </div>

    </div>

</div>


{{--<div class="absolute fixed-bottom">--}}
{{--    <a--}}
{{--        href="{{ controller_path() }}{{ controller_sep() }}md=auth&action=logout"--}}
{{--        type="button"--}}
{{--        class="py-2 px-3 text-white bg-red-ovlac px-4 hover:bg-red-700 hover:rounded-xl fs-4 logout-button"--}}

{{--    >--}}
{{--        {{ tra("Logout") }}--}}
{{--    </a>--}}
{{--</div>--}}
@endsection
