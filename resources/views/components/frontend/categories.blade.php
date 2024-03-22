@php
    if(!isset($models)) $models = [];
@endphp

@foreach($categories as $category)
    <div class="{{ $category->isChild() ? "px-4" : null}}">

        <x-frontend.category :category="$category" :models="$models"/>

    </div>
@endforeach

