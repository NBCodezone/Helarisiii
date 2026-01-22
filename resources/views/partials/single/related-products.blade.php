{{-- resources/views/partials/single/related-products.blade.php --}}
<div class="container-fluid related-product">
    <div class="container">
        <div class="mx-auto text-center pb-5" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius wow fadeInUp"
                data-wow-delay="0.1s">Related Products</h4>
            <p class="wow fadeInUp" data-wow-delay="0.2s">Discover more products from the same category that might interest you.</p>
        </div>
        <div class="related-carousel owl-carousel pt-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="related-item rounded">
                    <div class="related-item-inner border rounded">
                        <div class="related-item-inner-item">
                            <img src="{{ asset($relatedProduct->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $relatedProduct->product_name }}">
                            @if($relatedProduct->created_at->diffInDays(now()) <= 7)
                                <div class="related-new">New</div>
                            @endif
                            <div class="related-details">
                                <a href="{{ route('product.show', $relatedProduct->id) }}">
                                    <i class="fa fa-eye fa-1x"></i>
                                </a>
                            </div>
                        </div>
                        <div class="text-center rounded-bottom p-4">
                            <a href="{{ route('category', $relatedProduct->category_id) }}" class="d-block mb-2">{{ $relatedProduct->category->category_name ?? 'Uncategorized' }}</a>
                            <a href="{{ route('product.show', $relatedProduct->id) }}" class="d-block h4">
                                {{ Str::limit($relatedProduct->product_name, 30) }}
                            </a>
                            <span class="text-primary fs-5">¥{{ number_format($relatedProduct->price, 0) }}</span>
                        </div>
                    </div>
                    <div class="related-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                        <form action="{{ route('cart.add', $relatedProduct->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3">
                                <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                            </button>
                        </form>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('compare.add', $relatedProduct->id) }}"
                                class="text-primary d-flex align-items-center justify-content-center">
                                <span class="rounded-circle btn-sm-square border">
                                    <i class="fas fa-random"></i>
                                </span>
                            </a>
                            <a href="{{ route('wishlist.add', $relatedProduct->id) }}"
                                class="text-primary d-flex align-items-center justify-content-center">
                                <span class="rounded-circle btn-sm-square border">
                                    <i class="fas fa-heart"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
