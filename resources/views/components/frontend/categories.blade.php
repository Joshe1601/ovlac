@php
    if(!isset($models)) $models = '';
    if(!isset($collapsed)) $collapsed = false;
    if(!isset($counter)) $counter = 0;
$categoryId = ''
@endphp

@foreach($categories as $category)

    <div class="visor-menu {{ $category->is_last_node != 1 ? '' : 'd-none' }} {{ $category->optional != 1 ? '' : 'd-none' }}" >
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
               href="#description{{ $category->id }}"
               data-target="#body-{{ $category->id }}"
               aria-controls="body-{{ $category->id }}"
            >
                {{ $category->title }}
                @if($category->product_part_id != null)
                    <img
                        src="{{ relative_path() }}/public/images/ovlac/toggle_off.png"
                        alt="toggle Image"
                        data-closed-image="panel-{{ $category->id }}"
                        class="toggle"
                        width="40px">
                @endif
            </a>


        </div>


       @endif
    </div>

    @php
    $elementId = $category->before_last_node == 1 ? '' : 'body-' . $category->id;
    @endphp

    <div class="visor-body {{ $category->is_last_node == 1 ? ' ' : 'collapse' }} {{ $category->before_last_node == 1 ? 'show' : '' }}" id="{{$elementId}}" >
        <x-frontend.category :category="$category" :models="$models" :collapsed="false" :categoryId="$categoryId" :counter="$counter" />
    </div>
@endforeach

