{{-- @props([
        'target',
        'action',
        'product',
        //'product_part',
        //'product_part' => new App\Models\ProductPart(),
        'variable' => '1',
]) --}}

@if (!$product_part)
    @php
        $product_part = new App\Models\ProductPart();
    @endphp
@endif

<div class="modal fade" id="{{ $target }}" tabindex="-1" aria-labelledby="{{ $target }}" aria-hidden="true">
    <form method="POST" class="form_part form_part_{{$product_part->id}}" action="{{ controller_path() }}{{ controller_sep() }}md=product_part&product_id={{$product->id}}&action={{ $action }}@if ($product_part->id)&id={{$product_part->id}}@endif&api_token={{ $api_token }}" enctype="multipart/form-data">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($product_part->id)
                        <h1 class="modal-title fs-5" id="{{ $target }}">{{ tra("Edit") }}: <b>{{ $product_part->title }}</b></h1>
                    @else
                        <h1 class="modal-title fs-5" id="{{ $target }}">{{ tra("Create new part") }}:</h1>
                    @endif

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="product_id" name="product_id" type="hidden" value="{{ $product->id }}">
                    <input id="variable" name="variable" type="hidden" value="{{ $variable }}">
                    @if($variable == 1)
                        <input id="fixed" name="fixed" type="hidden" value="0">
                    @else
                        <input id="fixed" name="fixed" type="hidden" value="1">
                    @endif
                    <div class="pb-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="productname">{{ tra("Part Name") }}</label>
                                    <input id="title" name="title" type="text" class="form-control" value="{{ $product_part->title }}">
                                </div>
                                @if($variable == 1)
                                    <div class="form-group">
                                        <label for="price">{{ tra("Part Base Price") }}</label>
                                        <input id="price" name="price" type="text" class="form-control" value="{{ $product_part->price }}">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>{{ tra("Upload Part Model (.zip)") }}</label> <br>
                                        <div>{{ $product_part->model }}</div> <br>
                                        <input type="file" class="form-control-file" name="model">
                                        <button type="submit" name="submit" value="delete_model_{{$product_part->id}}" class="btn button-file-delete" data-bs-dismiss="modal">
                                            <i class="fa-solid fa-trash" style="color: #ff2600;"></i>
                                        </button>

                                        <br><br>
                                        <div>
                                            <input type="checkbox" name="colorize" id="colorize" @if ($product_part->color) checked @endif>
                                            <label for=colorize>{{ tra("Colorize part") }}</label>
                                            <div class="color-picker">
                                                <div style="background: url({{ relative_path() }}/public/images/select2.png) center;"></div>
                                                <input type="hidden" name="color" value="{{ $product_part->color }}" >
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="productdesc">{{ tra("Part Description") }}</label>
                                    <textarea name="description" class="form-control" id="productdesc" rows="5">{{ $product_part->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($variable == 1 && $product_part->id)
                        <div class="vars_form">
                            <h1 class="text-start modal-title fs-5 pb-2 pt-8" style="float: left">{{ tra("Part Variations") }}:</h1>
                            <div class="text-end mb-4">
                                <button type="button" class="btn btn-success btn-add-part" id_part="{{ $product_part->id }}" {{-- aria-current="true" data-bs-toggle="modal" data-bs-target="#variable_add" --}}>{{ tra("Add Variation Part") }}</button>
                            </div>
                            <div class="accordion" id="accordionParts">
                                @foreach ($product_part->subparts as $subpart)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $subpart->id }}" aria-expanded="false" aria-controls="collapse{{ $subpart->id }}">
                                                {{ $subpart->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $subpart->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionParts">
                                            <div class="accordion-body collapsed">
                                                @include('components.backend.product_part_variation.model_edit', ['action' => "update", 'product' => $product, 'product_part' => $subpart, 'parent_part' => $product_part, 'variable' => 1, 'level' => 1])
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer mt-4">
                    @if($product_part->id) <button type="submit" name="submit" value="remove_{{$product_part->id}}"  class="btn btn-danger" data-bs-dismiss="modal">Remove part</button>@endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ tra("Close") }}</button>
                    <button type="submit" name="submit" value="save" class="btn btn-primary waves-effect waves-light">{{ tra("Save Changes") }}</button>
                    {{-- <input type="submit" class="btn btn-primary" value="Save changes"></input> --}}
                </div>
            </div>
        </div>
    </form>


    <div class="accordion-item new-element" style="display: none;">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_new" aria-expanded="false" aria-controls="collapse_new">
                ---
            </button>
        </h2>
        <div id="collapse_new" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body collapsed">
                @include('components.backend.product_part_variation.model_edit', ['action' => "update", 'product' => $product, 'product_part' => $empty_part, 'parent_part' => $product_part, 'variable' => 1, 'level' => 2])
            </div>
        </div>
    </div>
</div>
