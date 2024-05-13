@php
    if(!isset($models)) $models = '';
    if(!isset($categoryId)) {
        dd('algo');
    }

@endphp

<div
    class="{{ $category->is_last_node == 1 ? 'lastNode ' : '' }}"
>
    @php
        if ($category->model !== '') {
            $data_model = json_encode(array($category->model, $category->price, $category->color, $category->id));
            $models = $models . ':' . $data_model;
        }
    @endphp

    @if ( $category->is_last_node == 1 )
        @if($category->product_part_id != null)
            <div id="description{{ $category->product_part_id }}"
                 class="collapse mx-3"
                 aria-expanded="{{ $collapsed ? 'false' : 'true' }}"
                 data-parent="#accordion"
                 data-accordion-content="panel-{{ $category->product_part_id }}"
            >
                <div

                >
{{--                    <label for="">{{ $category->title }} - {{ $category->id }}</label>--}}
                    <input
                        type="radio"
                        class="display_none"
                        name="is_last_node" id="#{{ $category->id }}"
                        value="{{ $models }}"

                        model-group="{{ $category->id }}">

{{--                    <img--}}
{{--                        src="{{ relative_path() }}{{ $category->image }}"--}}
{{--                        alt="Selected"--}}
{{--                        id="selected#{{ $category->id }}"--}}
{{--                        class="radio-image item-selected selectedModels"/>--}}
                    <span
                        id="selected#{{ $category->id }}"

                        class="radio-image item-selected selectedModels"
                    >
                        {{ $category->title }}
                    </span>
                </div>
            </div>
        @endif
    @endif
</div>

<div>
    <x-frontend.categories :categories="$category->children" :models="$models"/>
</div>


