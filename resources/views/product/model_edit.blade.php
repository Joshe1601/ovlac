@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token, 'is_admin' => $is_admin])
@endif

@section('content')
    {{--<x-backend.layout :product="$product">--}}
    <div class="container mx-auto px-4 py-2">
        <div>
            <h2 class="flex text-center mx-auto text-6xl px-8 py-4">{{ __('Product') }}</h2>
        </div>

        <div class="row">
            @if (!empty($_GET['error']))
                <div class="col-md-12 alert alert-danger">
                    {{ $_GET['error'] }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                @if (isset($product))
                    <div class="text-end" style="margin-left: 1.5rem">
                        <a
                            target="_blank"
                            href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}"
                            type="button"
                            class="text-white bg-red-ovlac hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            {{ tra("View Product") }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="px-3 py-2 mb-3 ">
            <div class=" mx-auto">

                <form
                    method="POST"
                    action="{{ controller_path() }}{{ controller_sep() }}md=product&action={{ $form_action }}@if ($product->id)&id={{$product->id}}@endif&api_token={{ $api_token }}"
                    enctype="multipart/form-data"
                    class="max-w-dm mx-auto"
                >

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Product Name") }}</label>
                            <input
                                type="text"
                                id="first_name"
                                name="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                placeholder="product name"
                                value="{{ $product->title }}"
                            />
                        </div>
                        <div>
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Base Price") }}</label>
                            <input
                                type="text"
                                id="price"
                                name="price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                placeholder="price"
                                value="{{ $product->price }}"
                            />
                        </div>
                        <div>
                            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Product Description") }}</label>
                            <textarea
                                type="text"
                                id="company"
                                name="description"
                                rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                placeholder="Flowbite"
                            >
                                {{ $product->description }}
                                </textarea>
                        </div>
                        <div>
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Product Image") }}</label>
                            @if ($product->image)
                                <img src="{{ relative_path() }}{{ $product->image }}" alt="product img" class="rounded-xl m-2 mx-auto" style="max-width: 250px;">
                                <button
                                    type="submit"
                                    name="submit"
                                    value="delete_image_{{$product->id}}"
                                    class="bg-white border border-gray-700 m-2 p-2 rounded-full hover:bg-gray-600"
                                    data-bs-dismiss="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                            <input
                                type="file"
                                id="file"
                                name="image"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                            />
                        </div>

                        <div><b>{{ tra("Scene Attributes") }}</b></div>
                        <div></div>
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                value="1"
                                id="has_light"
                                name="has_light"
                                {{ $product->has_light == 1 ? "checked" : ''}}
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label
                                for="has_light"
                                class="ms-2 text-dm text-gray-900 dark:text-gray-300">
                                Ambient Light
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                value="1"
                                id="has_shadow"
                                name="has_shadow"
                                {{ $product->has_shadow == 1 ? "checked" : ''}}
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label
                                for="has_shadow"
                                class="ms-2 text-dm text-gray-900 dark:text-gray-300"
                            >
                                Shadows
                            </label>
                        </div>

                        <div class="space-y-2">
                            <div><b>{{ tra("Camera Limits") }}</b></div>
                            <div>
                                <label for="camera_min_zoom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Min Zoom") }}</label>
                                <input type="text"
                                       id="camera_min_zoom"
                                       name="camera_min_zoom"
                                       value="{{ $product->camera_min_zoom }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>
                            <div>
                                <label for="camera_max_zoom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Max Zoom") }}</label>
                                <input type="text"
                                       id="camera_max_zoom"
                                       name="camera_max_zoom"
                                       value="{{ $product->camera_max_zoom }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>
                            <div>
                                <label for="camera_limit_x" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Horizontal Rotation Max Angle") }}</label>
                                <input type="text"
                                       id="camera_limit_x"
                                       name="camera_limit_x"
                                       value="{{ $product->camera_limit_x }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>
                            <div>
                                <label for="camera_limit_y" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ tra("Vertical Rotation Max Angle") }}</label>
                                <input type="text"
                                       id="camera_limit_y"
                                       name="camera_limit_y"
                                       value="{{ $product->camera_limit_y }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>
                        </div>


                        <div class="space-y-2">
                            <div><b>{{ tra("Camera Position") }}</b></div>
                            <div>
                                <label for="camera_x" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">X</label>
                                <input
                                    type="text"
                                    id="camera_x"
                                    name="camera_x"
                                    value="{{ $product->camera_x }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>
                            <div>
                                <label for="camera_y" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Y</label>
                                <input
                                    type="text"
                                    id="camera_y"
                                    name="camera_y"
                                    value="{{ $product->camera_y }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>
                            <div>
                                <label for="camera_z" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Z</label>
                                <input
                                    type="text"
                                    id="camera_z"
                                    name="camera_z"
                                    value="{{ $product->camera_z }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                />
                            </div>

                        </div>


                    </div> <!-- aqui terminan las dos columnas -->


                    <button
                        type="submit"
                        class="text-white bg-red-ovlac hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        {{ tra("Save Changes") }}
                    </button>

                    <a
                        type="button"
                        href="{{ controller_path() }}{{ controller_sep() }}module=product&action=index&api_token={{ $api_token }}"
                        class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                    >
                        {{ tra("Cancel") }}
                    </a>
                </form>

            </div>
        </div>
    </div>


    <hr class="container h-px my-8 bg-gray-400 border-0 dark:bg-gray-700 shadow-xl"> <!-- PARTES FIJAS Y VARIABLES - POPUPS -->



    @if ($form_action != 'store')
        <div class="container">
            <div class="">
                <div class="flex flex-row justify-content-between">
                    <div class="" role="search">
                        <h4 class="text-2xl font-bold">{{ tra("Fixed Product Parts") }}</h4>
                        <p class=""></p>
                    </div>
                    <div class="justify-end">
                        <a
                            href="#"
                            type="button"
                            class="rounded-xl bg-red-ovlac text-white px-6 py-3 hover:bg-red-800"
                            aria-current="true"
                            data-bs-toggle="modal" data-bs-target="#fixed_add">{{ tra("Add Fixed Part") }}</a>
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
                                        class="pb-3 sm:pb-4 hover:bg-gray-200"
                                        aria-current="true"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_part_{{ $product_part->id }}"
                                    >
                                        <div class="flex w-full items-center m-2 space-x-4 border-b p-2 hover:bg-gray-200 hover:rounded-xl">
                                            <div class="flex ml-4 my-2">
                                                <img class="w-8 h-8 rounded-full" src="{{ relative_path() }}/public/images/gear_fixed.png" alt="Fixed Part Product">
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="text-xl text-gray-900 font-bold">
                                                    {{ $product_part->title }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
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
                        <p class="card-title-desc"></p>
                    </div>

                    <div class="text-end">
                        <a
                            href="#"
                            type="button"
                            class="rounded-xl bg-red-ovlac text-white px-6 py-3 hover:bg-red-800"
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
                                    class="pb-3 sm:pb-4 hover:bg-gray-200"
                                    aria-current="true"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit_part_{{ $product_part->id }}"
                                >
                                    <div class="flex w-full items-center m-2 space-x-4 border-b p-2 hover:bg-gray-200 hover:rounded-xl">
                                        <div class="flex ml-4 my-2">
                                            <img class="w-8 h-8" src="{{ relative_path() }}/public/images/gear_variable.png" alt="Fixed Part Product">
                                        </div>
                                        <div class="flex flex-col">
                                            <p class="text-xl text-gray-900 font-bold">
                                                {{ $product_part->title }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
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
    </div>
</div>



</div>
@endsection
