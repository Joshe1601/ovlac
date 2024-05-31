@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token, 'is_admin' => $is_admin])
@endif

@section('content')



<div class="container mx-auto px-4 py-2">

    <div>
        <h1 class="h-2 mx-auto py-4">{{ tra('Products') }}</h1>
    </div>


    <div class="px-3 py-2 mb-3">
        <div class="d-flex flex-wrap justify-content-center">

            @if(isset($is_admin) && $is_admin == 1)
                <div class="row">
                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}module=product&action=create&api_token={{ $api_token }}"
                        type="button"
                        class="ovlac-button col align-self-end">
                        {{ tra("New Product") }}
                    </a>
                </div>
            @endif

            @if (isset($product))
                <div class="text-end" style="margin-left: 1.5rem">
                    <a target="_blank"
                       href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}"
                       type="button"
                       class="ovlac-button col align-self-end">
                        {{ tra("View Product") }}lll
                    </a>
                </div>
            @endif

        </div>
    </div>


    <div class="relative">
        <table class="table">
            <thead class="thead-light">
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
