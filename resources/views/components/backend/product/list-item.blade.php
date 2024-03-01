<tr>
    <td>
        <div class="d-flex align-items-center">
            <img
                src="{{ $product->product_image() }}"
                alt=""
                style="width: 45px; height: 45px"
                class="rounded-circle"
            />
            <div class="ms-3">
                <p class="fw-bold mb-1">{{ $product->title }}</p>
                <p class="text-muted mb-0">{{ $product->short_description() }}</p>
            </div>
        </div>
    </td>
    {{--    <td>--}}
    {{--    <span class="badge badge-success rounded-pill d-inline">Active</span>--}}
    {{--    </td>--}}
    <td>
        <p class="fw-normal mb-1">{{ $product->price }} €</p>
    </td>
    <td>
        <p class="fw-normal mb-1">[show_product_3d id={{ $product->id }}]</p>
    </td>
    <td>
        <a
            href="{{ controller_path() }}{{ controller_sep() }}action=show&module=product&id={{ $product->id }}"
            target="_blank"
            type="button"
            class="btn btn-success btn-rounded btn-sm fw-bold mr-2"
            data-mdb-ripple-color="dark"
        >
            View
        </a>

        @if(isset($isadmin) && $isadmin == 1)
            <a
                href="{{ controller_path() }}{{ controller_sep() }}action=edit&module=product&id={{ $product->id }}&api_token={{ $apitoken }}"
                type="button"
                class="btn btn-primary btn-rounded btn-sm fw-bold mr-2"
                data-mdb-ripple-color="dark"
            >
                Edit
            </a>
            <a
                href="{{ controller_path() }}{{ controller_sep() }}action=destroy&module=product&id={{ $product->id }}&api_token={{ $apitoken }}"
                type="button"
                class="btn btn-danger btn-rounded btn-sm fw-bold mr-2"
                data-mdb-ripple-color="dark"
            >
                Delete
            </a>
        @endif
    </td>
</tr>
