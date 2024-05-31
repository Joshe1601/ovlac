<div class="pb-4">
    <div class="row mb-4">
        <div class="col-sm-6">
            <input id="product_id" name="subparts[{{ $product_part->id }}][product_id]" type="hidden" value="{{ $product->id }}">
            <input id="product_part_id" class="form_product_part_id" name="subparts[{{ $product_part->id }}][product_part_id]" type="hidden" value="{{ $parent_part->id }}">
            <input id="variable" name="subparts[{{ $product_part->id }}][variable]" type="hidden" value="{{ $variable }}">
            <div class="form-group">
                <label for="productname">{{ tra("Part Variation Name") }}</label>
                <input id="title" name="subparts[{{ $product_part->id }}][title]" type="text" class="form-control" value="{{ $product_part->title }}">
            </div>
            <div class="form-group">
                <label for="price">{{ tra("Variation Price") }}</label>
                <input id="price" name="subparts[{{ $product_part->id }}][price]" type="text" class="form-control" value="{{ $product_part->price }}">
            </div>
            <div class="form-group">
                <label>{{ tra("Upload Part Model (.zip)") }}</label> <br>
                <div>{{ $product_part->model }}</div> <br>
                <input type="file" class="form-control-file" name="subparts[{{ $product_part->id }}][model]">
                <button type="submit" name="submit" value="delete_model_{{$product_part->id}}" class="btn button-file-delete" data-bs-dismiss="modal">
                    <i class="fa-solid fa-trash" style="color: #ff2600;"></i>
                </button>
                {{-- <button type="button" class="btn btn-info mt-2 waves-effect waves-light">Change Image</button> --}}
                <br><br>
                <div>
                    <input type="checkbox" name="subparts[{{ $product_part->id }}][colorize]" id="colorize" @if ($product_part->color) checked @endif>
                    <label for=colorize>{{ tra("Colorize part") }}</label>
                    <div class="color-picker">
                        <div style="background: url({{ relative_path() }}/public/images/select2.png) center;"></div>
                        <input type="hidden" name="subparts[{{ $product_part->id }}][color]" value="{{ $product_part->color }}" >
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="productdesc">{{ tra("Variation Description") }}</label>
                <textarea name="subparts[{{ $product_part->id }}][description]" class="form-control" id="productdesc" rows="5">{{ $product_part->description }}</textarea>
            </div>
            <div class="form-group">
                <label>{{ tra("Product Image") }}</label> <br>
                @if ($product_part->image) <img src="{{ relative_path() }}{{ $product_part->image }}" alt="product img" class="img-fluid rounded" style="max-width: 200px;">@endif
                <br>
                <input type="file" class="form-control-file" name="subparts[{{ $product_part->id }}][image]">
                <button type="submit" name="submit" value="delete_image_{{$product_part->id}}" class="btn button-file-delete" data-bs-dismiss="modal">
                    <i class="fa-solid fa-trash" style="color: #ff2600;"></i>
                </button>
            </div>
        </div>
    </div>



    @if($variable == 1 && $level < 2)
    <div class="vars_form mt-4">
        <h1 class="modal-title fs-5 pb-2 pt-8" style="float: left">Part Variations:</h1>
        <div class="text-end mb-4">
            @if($product_part->id)
                <button type="submit" name="submit" value="remove_{{$product_part->id}}" class="btn btn-danger btn-remove-part" data-bs-dismiss="modal">
                    {{ tra("Remove part") }}
                </button>
            @endif
            <button type="button" class="btn btn-success btn-add-part btn-add-part-fix" id_part="{{ $product_part->id }}" >{{ tra("Add Variation") }}</button>
        </div>
        <div class="accordion  accordion2" id="accordionSubParts{{$level}}">
            @foreach ($product_part->subparts as $subpart)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $subpart->id }}" aria-expanded="false" aria-controls="collapse{{ $subpart->id }}">
                            {{ $subpart->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $subpart->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionSubParts{{$level}}">
                        <div class="accordion-body collapsed">
                            @include('components.backend.product_part_variation.model_edit',
                                ['action' => "update",
                                'product' => $product,
                                'product_part' => $subpart,
                                'parent_part' => $product_part,
                                'variable' => 1,
                                'level' => $level+1])
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    @else
    <div class="text-end mb-4">
        @if($product_part->id) <button type="submit" name="submit" value="remove_{{$product_part->id}}" class="btn btn-danger btn-remove-part" data-bs-dismiss="modal">{{ tra("Remove part") }}</button>@endif
    </div>


        <div>
            <hr>
            @if ($product_part->id)
                <button type="button" class="btn btn-success btn-add-part" id_part="{{ $product_part->id }}">{{ tra("Add New Child") }}</button>
            @endif
            <!-- added -->
            <br />
            @foreach ($product_part->subparts as $subpart)
                <div
                    @class([
                        'accordion-item',
                        'bg-odd' => $level % 2 == 0,
                        'bg-even' => $level % 2 != 0,
                    ])
                >
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $subpart->id }}" aria-expanded="false" aria-controls="collapse{{ $subpart->id }}">
                            {{ $subpart->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $subpart->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionSubParts{{$level}}">
                        <div class="accordion-body collapsed">
                            @include('components.backend.product_part_variation.model_edit', ['action' => "update", 'product' => $product, 'product_part' => $subpart, 'parent_part' => $product_part, 'variable' => 1, 'level' => $level+1])
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    @endif
</div>
