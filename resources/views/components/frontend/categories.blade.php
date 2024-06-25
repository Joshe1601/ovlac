@php
    if(!isset($models)) $models = '';
    if(!isset($collapsed)) $collapsed = false;
    if(!isset($counter)) $counter = 0;
    if(!isset($optional)) $optional = 0;
$categoryId = ''
@endphp

@foreach($categories as $category)

    @php
        $accessoryId = $category->optional != 1 ? null : 'accessory' ;
        $subAccessoryId = $optional != 1 ? null : 'sub-accessory-'.$category->product_part_id;

    @endphp
    <div class="visor-menu {{ $category->is_last_node != 1 ? '' : 'd-none' }}{{ $category->optional != 1 ? '' : 'd-none' }}"
         @if($accessoryId) id="{{ $accessoryId }}" @endif
    >
        @if($category->is_last_node != 1)
        @php
            $categoryId = $category->id;
        @endphp
        <div class="visor-header"
             id="{{ $category->id }}"
             aria-expanded="{{ $collapsed ? 'false' : 'true' }}"
        >
            <a class="visor-link {{ $optional != 1 ? '' : 'sub-accessories' }}"
               data-toggle="collapse"
               data-accordion-button="panel-{{ $category->id }}"
               id="panel-{{ $category->id }}"
               href="#description{{ $category->id }}"
               data-target="#body-{{ $category->id }}"
               aria-controls="body-{{ $category->id }}"
               @if($subAccessoryId) data-accessory="{{ $subAccessoryId }}" @endif
            >
                {{ $category->title }}
                @if($category->product_part_id != null && $category->optional != 1)
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

    <div class="visor-body {{ $category->is_last_node == 1 ? ' ' : 'collapse' }} {{$counter == 0 ? 'show' : '' }}" id="body-{{$category->id }}" >
        <x-frontend.category :category="$category" :models="$models" :collapsed="false" :categoryId="$categoryId" :counter="$counter" :optional="$optional"/>
    </div>
@endforeach

