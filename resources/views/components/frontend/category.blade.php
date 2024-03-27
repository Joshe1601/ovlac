@php
    if(!isset($models)) $models = '';
@endphp

<div class="{{ $category->isLastNode == 1 ? 'lastNode' : '' }}">
    @php
        if ($category->model !== '') {
            $data_model = json_encode(array($category->model, $category->price, $category->color));
            $models = $models . ':' . $data_model;

        }
    @endphp

    @if ( $category->is_last_node == 1 )
{{--                {{ dd( $models[1]) }}--}}
        <label for="">{{ $category->title }}</label>
        <input type="radio" class="selectedModels" name="is_last_node" value="{{ $models }}" model-group="{{ $category->id }}">
    @else
        {{ $category->title }} / {{ $category->is_last_node == 1 ? '*****' : '' }}
    @endif

</div>
<x-frontend.categories :categories="$category->children" :models="$models"/>

