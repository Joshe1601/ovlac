@php
    if(!isset($models)) $models = '';
    if(!isset($categoryId)) {
        dd('algo');
    }
    if(!isset($counter)) $counter = 0;

    $children = $category->children;
    $lastChild = $children->last();
    if($children->count() != 1){
        $allExceptLast = $children->slice(0, $children->count() - 1);
    } else {
        $allExceptLast = $children;
    }

    $modelFatherId = $category->model_father = 0 ? null : $category->model_father;

@endphp
@php
    // Increment the counter for the next recursive level
    $counter++;
@endphp
<div
    class="{{ $category->is_last_node == 1 ? 'lastNode ' : '' }}"
>
{{--    <span>{{$allExceptLast}} </span>--}}

    @php
        if ($category->model !== '') {
            $data_model = json_encode(array($category->model, $category->price, $category->color, $category->id));
            $models = $models . ':' . $data_model;
        }
    @endphp

    @if ( $category->is_last_node == 1 )
        @if($category->product_part_id != null)
            <div id="{{ $category->product_part_id }}"
                 class="mx-3"
            >
                <div class="radio-image-container radio-image" id="{{$category->id}}"
                     @if($modelFatherId) radio-image-father="{{$modelFatherId }}" @endif
                >
                    <input
                        type="radio"
                        class="display_none"
                        name="is_last_node" id="#{{ $category->id }}"
                        value="{{ $models }}"

                        model-group="{{ $category->id }}">

                    <div
                        id="selected#{{ $category->id }}"
                        class="item-selected selectedModels">
                        <img
                            src="{{ relative_path() }}{{ $category->image }}"
                            alt=""
                            class=""
                            style="width:100%"
                        >
                        <div class="overlay">{{ $category->title }}</div>
                        <div
                            class="info-icon"
                            data-icon-detail="{{ $category->id }}"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="detail-panel" data-detail-panel="{{ $category->id }}">

                    <div class="detail-panel-title text-center">
                        {{ $category->title }}
                        <span class="detail-panel-close">x</span>
                    </div>
                    <div class="detail-panel-image">
                        <img src="{{ relative_path() }}{{ $category->image }}" alt="" style="width:245px;">
                    </div>
                    <div class="detail-panel-description text-center" >
                        {{ $category->description }}
                    </div>

            </div>
        @endif
    @endif
</div>
{{--    <span>{{$category->children}} </span>--}}
{{--<span>{{$counter}} </span>--}}
@if($counter == 2 && $category->optional !=1)
    <div class="roller-types">
        <h5>Tipos disponibles:</h5>
        <div class="container container-category-parts">
            <x-frontend.categories :categories="$allExceptLast" :models="$models" :counter="$counter"/>
        </div>
    </div>
    @if($children->count() != 1)
        <div>
            <x-frontend.categories :categories="[$lastChild]" :models="$models" :counter="$counter" :optional="$category->optional"/>
        </div>
    @endif
@elseif($counter == 3 && $optional = 1)
    <div>
        <x-frontend.categories :categories="$category->children" :models="$models" :counter="$counter" :optional="$optional"/>
    </div>
@elseif($counter == 4 && $optional = 1)
    <div class="roller-types pb-2">
        <x-frontend.categories :categories="$category->children" :models="$models" :counter="$counter" :optional="$optional"/>
    </div>
@elseif($counter == 4)
    <div class="roller-types">
        <h5>Tipos disponibles:</h5>
        <div class="container container-category-parts">
            <x-frontend.categories :categories="$category->children" :models="$models" :counter="$counter"/>
        </div>
    </div>
@else
    <div>
        <x-frontend.categories :categories="$category->children" :models="$models" :counter="$counter" :optional="$category->optional"/>
    </div>
@endif
