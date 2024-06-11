@php
    if(!isset($models)) $models = '';
    if(!isset($categoryId)) {
        dd('algo');
    }
    if(!isset($counter)) $counter = 0;

@endphp
@php
    // Increment the counter for the next recursive level
    $counter++;
@endphp
<div
    class="{{ $category->is_last_node == 1 ? 'lastNode ' : '' }}"
>
    @php
        if ($category->model !== '') {
            $data_model = json_encode(array($category->model, $category->price, $category->color, $category->id));
            $models = $models . ':' . $data_model;
        }
    @endphp

    @if ( $category->is_last_node == 1 )
        @if($category->product_part_id != null)
            <div id="{{ $category->product_part_id }}"
                 class="collapse mx-3"
                 aria-expanded="{{ $collapsed ? 'false' : 'true' }}"
                 data-parent="#accordion"
                 data-accordion-content="panel-{{ $category->product_part_id }}"
            >
                <div class="radio-image-container radio-image">
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
<span>{{$counter}}</span>
<div class="{{ $counter == 2 ? 'container container-category-parts' : '' }}">
    <x-frontend.categories :categories="$category->children" :models="$models" :counter="$counter"/>
</div>


