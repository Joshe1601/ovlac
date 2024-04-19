@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token, 'is_admin' => $is_admin])
@endif

@section('content')
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
                        <a target="_blank"  href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}" type="button" class="btn btn-primary">{{ tra("View Product") }}</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="px-3 py-2 mb-3 ">
            <div class=" mx-auto">



                <form
                    method="POST"
                    action="{{ controller_path() }}{{ controller_sep() }}md=user&action={{ $form_action }}&api_token={{ $api_token }}"
                    aria-label="{{ __('Register') }}"
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
                            @if ($product->image) <img src="{{ relative_path() }}{{ $product->image }}" alt="product img" class="rounded rounded-xl" style="max-width: 200px;">@endif
                            <input
                                type="file"
                                id="file"
                                name="file"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                            />
                            <button type="submit" name="submit" value="delete_image_{{$product->id}}" class="btn button-file-delete" data-bs-dismiss="modal">
                                <i class="fa-solid fa-trash" style="color: #ff2600;"></i>
                            </button>
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

                    <button
                        type="submit"
                        class="text-white bg-gray-500 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        {{ tra("Cancel") }}
                    </button>



                </form>


            </div>
        </div>

    </div>




{{--    old form--}}

        <div class="container-fluid">

            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">{{ tra("Product Edit") }}</h4>

                    </div>
                </div>
            </div>

           <div class="row">
               <div class="col-md-12 mb-3">
                   @if (isset($product))
                       <div class="text-end" style="margin-left: 1.5rem">
                           <a target="_blank"  href="{{ controller_path() }}{{ controller_sep() }}module=product&action=show&id={{ $product->id }}" type="button" class="btn btn-primary">{{ tra("View Product") }}</a>
                       </div>
                   @endif
               </div>
           </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">{{ tra("Basic Information") }}</h4>

                            <form method="POST"
                                  action="{{ controller_path() }}{{ controller_sep() }}md=product&action={{ $form_action }}@if ($product->id)&id={{$product->id}}@endif&api_token={{ $api_token }}"
                                  enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">

{{--                                        <div class="form-group">--}}
{{--                                            <label for="title">{{ tra("Product Name") }}</label>--}}
{{--                                            <input id="title" name="title" type="text" class="form-control" value="{{ $product->title }}">--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group">--}}
{{--                                            <label for="price">{{ tra("Base Price") }}</label>--}}
{{--                                            <input id="price" name="price" type="text" class="form-control" value="{{ $product->price }}">--}}
{{--                                        </div>--}}


                                    </div>

{{--                                    <div class="col-sm-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="productdesc">{{ tra("Product Description") }}</label>--}}
{{--                                            <textarea name="description" class="form-control" id="productdesc" rows="4">{{ $product->description }}</textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>



                                <div class="row">
                                    <div class="col-sm-6">
                                    </div>
{{--                                    <div class="col-sm-6">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>{{ tra("Product Image") }}</label> <br>--}}
{{--                                            @if ($product->image) <img src="{{ relative_path() }}{{ $product->image }}" alt="product img" class="img-fluid rounded" style="max-width: 200px;">@endif--}}
{{--                                            <br>--}}
{{--                                            <input type="file" class="form-control-file" name="image">--}}
{{--                                            <button type="submit" name="submit" value="delete_image_{{$product->id}}" class="btn button-file-delete" data-bs-dismiss="modal">--}}
{{--                                                <i class="fa-solid fa-trash" style="color: #ff2600;"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>

                                <br><hr><br>

                                <h4 class="card-title">{{ tra("Camera Options") }}</h4>
                                <div class="row">

                                    <div class="col-sm-6">


{{--                                        <div><b>{{ tra("Camera Position") }}</b></div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_x">X</label>--}}
{{--                                            <input id="camera_x" name="camera_x" type="text" class="form-control" value="{{ $product->camera_x }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_y">Y</label>--}}
{{--                                            <input id="camera_y" name="camera_y" type="text" class="form-control" value="{{ $product->camera_y }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_z">Z</label>--}}
{{--                                            <input id="camera_z" name="camera_z" type="text" class="form-control" value="{{ $product->camera_z }}">--}}
{{--                                        </div>--}}




{{--                                        <div class="form-group">--}}
{{--                                            <br>--}}
{{--                                            <input--}}
{{--                                                type="checkbox" value="1" class="p-3 col-sm"--}}
{{--                                                {{ $product->has_light == 1 ? "checked" : ''}}--}}
{{--                                                id="has_light" name="has_light" >--}}
{{--                                            <label for="has_light" class="mr-3">Ambient Light</label>--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group">--}}
{{--                                            <br>--}}
{{--                                            <input--}}
{{--                                                type="checkbox" value="1" class="p-3 col-sm"--}}
{{--                                                {{ $product->has_shadow == 1 ? "checked" : ''}}--}}
{{--                                                id="has_shadow" name="has_shadow" >--}}
{{--                                            <label for="has_shadow ">Shadows</label>--}}
{{--                                        </div>--}}

                                    </div>



{{--                                    <div class="col-sm-6">--}}
{{--                                        <div><b>{{ tra("Camera Limits") }}</b></div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_min_zoom">{{ tra("Min Zoom") }}</label>--}}
{{--                                            <input id="camera_min_zoom" name="camera_min_zoom" type="text" class="form-control" value="{{ $product->camera_min_zoom }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_max_zoom">{{ tra("Max Zoom") }}</label>--}}
{{--                                            <input id="camera_max_zoom" name="camera_max_zoom" type="text" class="form-control" value="{{ $product->camera_max_zoom }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_limit_x">{{ tra("Horizontal Rotation Max Angle") }}</label>--}}
{{--                                            <input id="camera_limit_x" name="camera_limit_x" type="text" class="form-control" value="{{ $product->camera_limit_x }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="camera_limit_y">{{ tra("Vertical Rotation Max Angle") }}</label>--}}
{{--                                            <input id="camera_limit_y" name="camera_limit_y" type="text" class="form-control" value="{{ $product->camera_limit_y }}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


                                </div>
                                <br />
                                <button type="submit" class="btn btn-success mr-1 waves-effect waves-light">{{ tra("Save Changes") }}</button>
                                <button type="submit" class="btn btn-secondary waves-effect">{{ tra("Cancel") }}</button>
                            </form>

                        </div>
                    </div>

<!--  END OF OLD FORM -->

                    <br>


                    <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                    </div>
                    @if ($form_action != 'store')
                    <div class="card">
                        <div class="card-body">
                            <div class="container d-flex flex-wrap justify-content-center">
                                <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                                    <h4 class="card-title">{{ tra("Fixed Product Parts") }}</h4>
                                    <p class="card-title-desc"></p>
                                </div>

                                <div class="text-end">
                                    <a href="#" type="button" class="btn btn-success" aria-current="true" data-bs-toggle="modal" data-bs-target="#fixed_add">{{ tra("Add Fixed Part") }}</a>
                                </div>
                                {{-- <x-backend.product_part.model_edit target="fixed_add" action="store" :product="$product" :product_part="" variable="0" /> --}}
                                @include('components.backend.product_part.model_edit', ['target' => 'fixed_add', 'action' => "update", 'product' => $product, 'product_part' => null, 'variable' => 0])
                            </div>

                            {{-- <form> --}}
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="list-group w-auto">


                                    @foreach ($product->fixed_parts as $product_part)
                                        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" data-bs-toggle="modal" data-bs-target="#edit_part_{{ $product_part->id }}">
                                            <img src="{{ relative_path() }}/public/images/gear.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                                            <div class="d-flex gap-2 w-100 justify-content-between">
                                                <div>
                                                <h6 class="mb-0">{{ $product_part->title }}</h6>
                                                <p class="mb-0 opacity-75">{{ $product_part->description }}</p>
                                                </div>
                                                {{-- <small class="opacity-50 text-nowrap"><i class="fa-solid fa-trash" style="color: #ff2600;"></i></small> --}}
                                            </div>
                                        </a>
                                        {{-- <x-backend.product_part.model_edit target="edit_part_{{ $product_part->id }}" action="update" :product="$product" :product_part="$product" variable="0" /> --}}
                                        @include('components.backend.product_part.model_edit', ['target' => 'edit_part_'.$product_part->id, 'action' => "update", 'product' => $product, 'product_part' => $product_part, 'variable' => 0])
                                    @endforeach

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="container d-flex flex-wrap justify-content-center">
                                <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                                    <h4 class="card-title">{{ tra("Variable Product Parts") }}</h4>
                                    <p class="card-title-desc"></p>
                                </div>

                                <div class="text-end">
                                    <a href="#" type="button" class="btn btn-success" aria-current="true" data-bs-toggle="modal" data-bs-target="#variable_add">{{ tra("Add Variable Part") }}</a>
                                </div>
                                @include('components.backend.product_part.model_edit', ['target' => 'variable_add', 'action' => "update", 'product' => $product, 'product_part' => null, 'variable' => 1])
                            </div>

                            {{-- <form> --}}


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group w-auto">
                                        @foreach ($product->variable_parts as $product_part)
                                            <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" data-bs-toggle="modal" data-bs-target="#edit_part_{{ $product_part->id }}">
                                                <img src="{{ relative_path() }}/public/images/gear.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                    <h6 class="mb-0">{{ $product_part->title }}</h6>
                                                    <p class="mb-0 opacity-75">{{ $product_part->description }}</p>
                                                    </div>
                                                    {{-- <small class="opacity-50 text-nowrap"><i class="fa-solid fa-trash" style="color: #ff2600;"></i></small> --}}
                                                </div>
                                            </a>
                                            @include('components.backend.product_part.model_edit', ['target' => 'edit_part_'.$product_part->id, 'action' => "update", 'product' => $product, 'product_part' => $product_part, 'variable' => 1])
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            {{-- <br>
                            <button type="submit" class="btn btn-success mr-1 waves-effect waves-light">Save Changes</button>
                            <button type="submit" class="btn btn-secondary waves-effect">Cancel</button>
 --}}
                            {{-- </form> --}}

                        </div>
                    </div>
                    @endif
                </div>
            </div>



        </div>

{{--</x-backend.layout>--}}
@endsection
