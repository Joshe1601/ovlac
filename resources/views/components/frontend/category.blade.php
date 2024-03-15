<div class="{{ $category->isLastNode == 1 ? 'lastNode' : '' }}">{{ $category->title }}</div>
<x-frontend.categories :categories="$category->children" />


