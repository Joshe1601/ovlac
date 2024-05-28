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
                src="{{ relative_path() }}/public/images/ovlac/toggle_off.png"
                alt="toggle Image"
                data-closed-image="panel-{{ $category->id }}"
                class="toggle"
                width="40px">
        </div>


       @endif
    </div>

    <div class="visor-body">
        <x-frontend.category :category="$category" :models="$models" :collapsed="false" :categoryId="$categoryId"/>
    </div>

@endforeach

