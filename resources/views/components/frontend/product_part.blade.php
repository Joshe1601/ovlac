{{-- @props(['first' => false]) --}}

<li>
    <div class="variation_head">
        <img class="variation_img" src="{!! $product_part->part_image() !!}" >
        <div class="variation_text">
            <div class="variation_title">{{ $product_part->title }}</div>
            <div class="variation_description">{{ $product_part->description }}</div>
        </div>
    </div>
    <div class="variation_vars">
        <ul class="sub_variation">
            @forelse ($product_part->subparts as $key => $subpart)
            <li>
                <input class="x{{ $product_part->id }}_subvar_radio subvar_radio" @if ($subpart->color) colorize="{{ $subpart->color }}" @endif
                    type="radio" name="{{ $group }}" id="x{{ $product_part->id }}_{{ $subpart->id }}" @if ($key == 0)
                    {{-- checked --}}
                @endif value="{{ $subpart->model_def() }}" model-group="{{ $group }}" part_base_price="{{ $subpart->price_full() }}">
                <label title="{{ $subpart->title }}" part_id="{{ $subpart->id }}" for="x{{ $product_part->id }}_{{$subpart->id}}">
                    @if ($subpart->part_image() != '')
                    <span>
                        <img class="product_part_image" src="{{ $subpart->part_image() }}" />
                    </span>
                    @else
                        <span style="background-color: #{{$subpart->color_bg()}};"></span>
                    @endif

                </label>
            </li>
            @empty
                <li>
                    <input class="x{{ $product_part->id }}_subvar_radio subvar_radio" type="radio" name="{{ $group }}" id="x{{ $product_part->id }}_0"
                           value="{{ $product_part->model }}" model-group="{{ $group }}" part_base_price="{{ $product_part->price_full() }}">
                    <label title="{{ $product_part->title }}" part_id="{{ $subpart->id }}" for="x{{ $product_part->id }}_0">
                        <span style="background-color: #dddddd;"></span>
                    </label>
                </li>
            @endforelse
        </ul>
        <div class="variation_price" >+<span class="price_value">{{ $product_part->price_full() }}</span>€</div>
    </div>
</li>
