@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token, 'is_admin' => $is_admin])
@endif

@section('content')
    {{--<x-backend.layout :product="$product">--}}

    <div class="container py-5">
        <div class="row">
            <div>
                <h2 class="flex text-center mx-auto text-6xl px-8 py-4">{{ tra('Product') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="px-3 py-2 mb-3">
                <div class="d-flex flex-wrap justify-content-end">
                    @if (isset($product))
                        <div class="">
                            <a
                                target="_blank"
                                href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}"
                                type="button"
                                class="ovlac-button col align-self-end"
                            >
                                {{ tra("View Product") }}
                                {{--                                {{ $product }}--}}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <form
                    method="POST"
                    action="{{ controller_path() }}{{ controller_sep() }}md=product&action={{ $form_action }}@if ($product->id)&id={{$product->id}}@endif&api_token={{ $api_token }}"
                    enctype="multipart/form-data"
                    class="max-w-dm mx-auto"
                >
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Product Name") }}</label>
                            <input
                                type="text"
                                id="first_name"
                                name="title"
                                class="form-control"
                                placeholder="product name"
                                value="{{ $product->title }}"
                            />
                        </div>
                        <div class="col-sm-6">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Base Price") }}</label>
                            <input
                                type="text"
                                id="price"
                                name="price"
                                class="form-control"
                                placeholder="price"
                                value="{{ $product->price }}"
                            />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Product Description") }}</label>
                            <textarea
                                type="text"
                                id="company"
                                name="description"
                                rows="4"
                                class="form-control"
                                placeholder="Description"
                            >
                                {{ $product->description }}
                                </textarea>
                        </div>
                        <div class="col-sm-6 d-flex flex-column">
                            <label for="file" class="form-label">{{ tra("Product Image") }}</label>
                            @if ($product->image)
                                <div class="flex flex-row m-4 justify-content-between">
                                    <img
                                        src="{{ relative_path() }}{{ $product->image }}"
                                        alt="product img"
                                        class="rounded mx-auto" style="max-width: 250px;">
                                    <button
                                        type="submit"
                                        name="submit"
                                        value="delete_image_{{$product->id}}"
                                        class="delete-image"
                                        data-bs-dismiss="modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="">
                                            <path fill-rule="evenodd"
                                                  d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                            <input
                                type="file"
                                id="file"
                                name="image"
                                class="form-control"
                            />
                        </div>
                    </div>


                    <h5>{{ tra('Scene Attributes') }}</h5>
                    <div class="form-group row">
                        <div class="col-sm-6 form-check ml-3">
                            <input
                                type="checkbox"
                                value="1"
                                id="has_light"
                                name="has_light"
                                {{ $product->has_light == 1 ? "checked" : ''}}
                                class="form-check-input"
                            >
                            <label
                                for="has_light"
                                class="form-check-label">
                                Ambient Light
                            </label>
                        </div>

                        <div class="col-sm-3 form-check ml-3">
                            <input
                                type="checkbox"
                                value="1"
                                id="has_shadow"
                                name="has_shadow"
                                {{ $product->has_shadow == 1 ? "checked" : ''}}
                                class="form-check-input"
                            >
                            <label
                                for="has_shadow"
                                class="form-check-label">
                                Shadows
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <h5>{{ tra('Camera Limits') }}</h5>
                            <label for="camera_min_zoom"
                                   class="form-label">{{ tra("Min Zoom") }}</label>
                            <input type="text"
                                   id="camera_min_zoom"
                                   name="camera_min_zoom"
                                   value="{{ $product->camera_min_zoom }}"
                                   class="form-control"
                            />
                            <label for="camera_max_zoom"
                                   class="form-label">{{ tra("Max Zoom") }}</label>
                            <input type="text"
                                   id="camera_max_zoom"
                                   name="camera_max_zoom"
                                   value="{{ $product->camera_max_zoom }}"
                                   class="form-control"
                            />
                            <label for="camera_limit_x"
                                   class="form-label">{{ tra("Horizontal Rotation Max Angle") }}</label>
                            <input type="text"
                                   id="camera_limit_x"
                                   name="camera_limit_x"
                                   value="{{ $product->camera_limit_x }}"
                                   class="form-control"
                            />
                            <label for="camera_limit_y"
                                   class="form-label">{{ tra("Vertical Rotation Max Angle") }}</label>
                            <input type="text"
                                   id="camera_limit_y"
                                   name="camera_limit_y"
                                   value="{{ $product->camera_limit_y }}"
                                   class="form-control"
                            />

                        </div>
                        <div class="col-sm-6">
                            <h5>{{ tra('Camera Position') }}</h5>
                            <label for="camera_x"
                                   class="form-label">X</label>
                            <input
                                type="text"
                                id="camera_x"
                                name="camera_x"
                                value="{{ $product->camera_x }}"
                                class="form-control"
                            />
                            <label for="camera_y"
                                   class="form-label">Y</label>
                            <input
                                type="text"
                                id="camera_y"
                                name="camera_y"
                                value="{{ $product->camera_y }}"
                                class="form-control"
                            />
                            <label for="camera_z"
                                   class="form-label">Z</label>
                            <input
                                type="text"
                                id="camera_z"
                                name="camera_z"
                                value="{{ $product->camera_z }}"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            <button type="submit"
                                    class="ovlac-button">
                                {{ tra("Save Changes") }}
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <a
                                type="button"
                                href="{{ controller_path() }}{{ controller_sep() }}module=product&action=index&api_token={{ $api_token }}"
                                class="cancel-button"
                            >
                                {{ tra("Cancel") }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<!-- HERE THE OLD CODE -->


    <hr class="container">
    <!-- PARTES FIJAS Y VARIABLES - POPUPS -->



    @if ($form_action != 'store')

        <div class="container bg-white">
            <div class="">
                <div class="flex flex-col justify-content-center">
                    <div class="" role="search">
                        <h4 class="text-2xl font-bold">{{ tra("Fixed Product Parts") }}</h4>
                    </div>
                    <div class="text-end">
                        <a
                            href="#"
                            type="button"
                            class="part-button"
                            aria-current="true"
                            data-bs-toggle="modal"
                            data-bs-target="#fixed_add">{{ tra("Add Fixed Part") }}</a>
                    </div>
                    @include('components.backend.product_part.model_edit',
                            ['target' => 'fixed_add', 'action' => "update",
                            'product' => $product,
                            'product_part' => null,
                            'variable' => 0])
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <div class="max-w-full divide-y divide-gray-200 hover:divide-gray-700">
                            @foreach ($product->fixed_parts as $product_part)
                                    <a
                                        href="#"
                                        class=""
                                        aria-current="true"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_part_{{ $product_part->id }}"
                                    >
                                        <div class="d-flex flex-row w-full items-center m-2 part-list-item">
                                            <div class="ml-4 my-2">
                                                <img class="rounded-circle part-icon" src="{{ relative_path() }}/public/images/gear_fixed.png" alt="Fixed Part Product">
                                            </div>
                                            <div class="d-flex flex-column ml-4">
                                                <p class="fs-4 font-weight-bold text-gear m-1">
                                                    {{ $product_part->title }}
                                                </p>
                                                <p class="fs-6 font-weight-light text-gear">
                                                    {{ $product_part->description }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @include('components.backend.product_part.model_edit', ['target' => 'edit_part_'.$product_part->id, 'action' => "update", 'product' => $product, 'product_part' => $product_part, 'variable' => 0])
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container bg-white">
            <div class="">
                <div class="flex flex-col justify-content-center">
                    <div class="mt-4" role="search">
                        <h4 class="text-2xl font-bold">{{ tra("Variable Product Parts") }}</h4>
                    </div>

                    <div class="text-end">
                        <a
                            href="#"
                            type="button"
                            class="part-button"
                            aria-current="true"
                            data-bs-toggle="modal"
                            data-bs-target="#variable_add">{{ tra("Add Variable Part") }}</a>
                    </div>
                    @include('components.backend.product_part.model_edit', ['target' => 'variable_add', 'action' => "update", 'product' => $product, 'product_part' => null, 'variable' => 1])
                </div>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="w-auto">
                            @foreach ($product->variable_parts as $product_part)
                                <a
                                    href="#"
                                    class="part-list-item"
                                    aria-current="true"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit_part_{{ $product_part->id }}"
                                >
                                    <div class="d-flex flex-row w-full items-center m-2 part-list-item">
                                        <div class="ml-4 my-2">
                                            <img class="part-icon" src="{{ relative_path() }}/public/images/gear_variable.png" alt="Fixed Part Product">
                                        </div>
                                        <div class="d-flex flex-column ml-4">
                                            <p class="fs-4 font-weight-bold text-gear m-1">
                                                {{ $product_part->title }}
                                            </p>
                                            <p class="fs-6 font-weight-light text-gear">
                                                {{ $product_part->description }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                @include('components.backend.product_part.model_edit',
                                        ['target' => 'edit_part_'.$product_part->id,
                                        'action' => "update",
                                        'product' => $product,
                                        'product_part' => $product_part,
                                        'variable' => 1])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="footer"></div>
@endsection
