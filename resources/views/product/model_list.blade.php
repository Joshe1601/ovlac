@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token, 'is_admin' => $is_admin])
@endif

@section('content')
{{--<x-backend.layout :isadmin=$is_admin >--}}

<div class="px-3 py-2 mb-3">
    <div class="container d-flex flex-wrap justify-content-center">
        <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            {{-- <input type="search" class="form-control" placeholder="Search..." aria-label="Search"> --}}
        </form>

        @if(isset($is_admin) && $is_admin == 1)
            <div class="text-end">
                <a href="{{ controller_path() }}{{ controller_sep() }}module=product&action=create&api_token={{ $api_token }}" type="button" class="btn btn-success">{{ tra("New Product") }}</a>
            </div>
        @endif

        @if (isset($product))
            <div class="text-end" style="margin-left: 1.5rem">
                <a target="_blank"  href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}" type="button" class="btn btn-primary">{{ tra("View Product") }}</a>
            </div>
        @endif

    </div>

    <h2>Products</h2>
</div>

    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
        <tr>
            <th>{{ tra("Product") }}</th>
{{--            <th>{{ tra("Status") }}</th>--}}
            <th>{{ tra("Base Price") }}</th>
            <th>{{ tra("Shortcode") }}</th>
            <th>{{ tra("Actions") }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <x-backend.product.list-item :product=$product :apitoken=$api_token :isadmin=$is_admin />
            @endforeach


        </tbody>
    </table>
{{--</x-backend.layout>--}}

@endsection
