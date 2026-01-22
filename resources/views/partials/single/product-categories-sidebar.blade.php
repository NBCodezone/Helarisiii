{{-- resources/views/partials/single/product-categories-sidebar.blade.php --}}
<div class="product-categories mb-4">
    <h4>Products Categories</h4>
    <ul class="list-unstyled">
        @foreach($categories as $category)
            <li>
                <div class="categories-item">
                    <a href="{{ route('category', $category->id) }}" class="text-dark">
                        <i class="fas fa-apple-alt text-secondary me-2"></i>
                        {{ $category->category_name }}
                    </a>
                    <span>({{ $category->products_count ?? 0 }})</span>
                </div>
            </li>
        @endforeach
    </ul>
</div>
