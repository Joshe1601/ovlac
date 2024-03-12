@foreach($categories as $category)
    <div class="{{ $category->isChild() ? "px-4" : null}}">
        <x-frontend.category :category="$category" />
    </div>
@endforeach
