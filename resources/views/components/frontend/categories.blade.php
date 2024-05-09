@php
    if(!isset($models)) $models = '';
@endphp

@foreach($categories as $category)

    <div class="visor-menu">
        @if($category->is_last_node != 1)
        <div class="visor-header">
            <a class="visor-link"
               data-toggle="collapse"
{{--               aria-expanded="{{ $collapsed ? 'false' : 'true' }}"--}}
               href="#description{{ $category->id }}">
                {{ $category->title }}
            </a>
        </div>
       @endif
    </div>


    <div class="visor-body">
        <x-frontend.category :category="$category" :models="$models" :collapsed="false" />
    </div>


@endforeach

