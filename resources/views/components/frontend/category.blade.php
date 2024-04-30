@php
    if(!isset($models)) $models = '';
@endphp

<div class="{{ $category->is_last_node == 1 ? 'lastNode' : '' }}">
    @php
        if ($category->model !== '') {
            $data_model = json_encode(array($category->model, $category->price, $category->color, $category->id));
            $models = $models . ':' . $data_model;
        }
    @endphp

    @if ( $category->is_last_node == 1 )
{{--                {{ dd( $models[1]) }}--}}
        @if($category->product_part_id != null)
            <div id="description{{ $category->product_part_id }}"
                 class="collapse show"
                 data-parent="#accordion">
                <div class="card-body">
                    <label for="">{{ $category->title }} - {{ $category->id }} AQUI VA UNA IMAGEN </label>
                    <input type="radio" class="selectedModels " name="is_last_node" value="{{ $models }}" model-group="{{ $category->id }}">
                </div>
            </div>
        @endif

    @else
{{--        {{ $category->title }} / {{ $category->is_last_node == 1 ? '*****' : '' }}--}}

        @if($category->product_part_id != null && $category->is_last_node != 1)
            <div id="description{{ $category->product_part_id }}"
                 class="collapse show"
                 data-parent="#accordion">
                <div class="card-body">
                    {{ $category->title }}
                </div>
            </div>
        @endif
    @endif

</div>
<x-frontend.categories :categories="$category->children" :models="$models"/>

