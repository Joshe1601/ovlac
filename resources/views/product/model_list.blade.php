@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token, 'is_admin' => $is_admin])
@endif

@section('content')



<div class="container mx-auto px-4 py-2">

    <div>
        <h2 class="flex text-center mx-auto text-6xl px-8 py-4">Products</h2>
    </div>


    <div class="px-3 py-2 mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                {{-- <input type="search" class="form-control" placeholder="Search..." aria-label="Search"> --}}
            </form>

            @if(isset($is_admin) && $is_admin == 1)
                <div class="text-end">
                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}module=product&action=create&api_token={{ $api_token }}"
                        type="button"
                        class="bg-red-ovlac px-6 py-3 m-4 rounded rounded-xl text-white hover:bg-red-700">
                        {{ tra("New Product") }}
                    </a>
                </div>
            @endif

            @if (isset($product))
                <div class="text-end" style="margin-left: 1.5rem">
                    <a target="_blank"
                       href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}"
                       type="button"
                       class="btn btn-primary">{{ tra("View Product") }}</a>
                </div>
            @endif

        </div>
    </div>


    <div class="relative">
        <table class="w-full text-md text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ tra("Product") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ tra("Base Price") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ tra("Short Code") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ tra("Actions") }}
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <x-backend.product.list-item :product=$product :apitoken=$api_token :isadmin=$is_admin />
                @endforeach

            </tbody>
        </table>
    </div>
</div>


@endsection
