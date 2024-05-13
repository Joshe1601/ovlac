@php
    if(!isset($models)) $models = '';
    if(!isset($collapsed)) $collapsed = false;
    $categoryId = ''
@endphp

@foreach($categories as $category)

    <div class="visor-menu" >
        @if($category->is_last_node != 1)
            @php

                $categoryId = $category->id;
            @endphp

        <div class="visor-header"
             id="{{ $category->id }}"
             aria-expanded="{{ $collapsed ? 'false' : 'true' }}"
        >
            <a class="visor-link"
               data-toggle="collapse"
                data-accordion-button="panel-{{ $category->id }}"
               id="panel-{{ $category->id }}"
               href="#description{{ $category->id }}">
                {{ $category->title }}
            </a>
            <img
                src="{{ relative_path() }}/public/images/ovlac/toggle_on.png"
                alt=""
                class="toggle-on display_none"
                id="toggle_on_{{ $category->id }}"
            >
            <img
                src="{{ relative_path() }}/public/images/ovlac/toggle_off.png"
                alt=""
                class="toggle-off"
                id="toggle_off_{{ $category->id }}"
            >
        </div>


       @endif
    </div>

    <div class="visor-body">
        <x-frontend.category :category="$category" :models="$models" :collapsed="false" :categoryId="$categoryId"/>
    </div>

@endforeach

