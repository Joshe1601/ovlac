@php
    if(!isset($models)) $models = '';
@endphp

@foreach($categories as $category)

    <div class="card">
        @if($category->is_last_node != 1)
        <div class="card-header">
            <a class="card-link"
               data-toggle="collapse"
               href="#description{{ $category->id }}">
                {{ $category->title }}
            </a>
        </div>

    @endif



            <x-frontend.category :category="$category" :models="$models"/>
    </div>
@endforeach

