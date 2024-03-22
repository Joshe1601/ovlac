@php
    if(!isset($models)) $models = [];
@endphp

<div class="{{ $category->isLastNode == 1 ? 'lastNode' : '' }}">
    @php
        if ($category->model !== null) array_push($models, $category->model)
    @endphp
    {{ $category->title }} {{ $category->is_last_node == 1 ? '*****' : '' }}
    @if ( $category->is_last_node == 1 && isset($models) )
{{--        {{ dd( $models ) }}--}}
    @endif

</div>
<x-frontend.categories :categories="$category->children" :models="$models"/>

