@auth
    @forelse($wishlistItems as $item)
        <li class="list-group-item d-flex justify-content-between lh-sm wishlist-offcanvas-item"
            data-wishlist-id="{{ $item->id }}" data-product-id="{{ $item->product_id }}">
            <div class="d-flex justify-center">
                <a href="#" class="d-flex align-items-center remove-offcanvas-wishlist"
                    data-wishlist-id="{{ $item->id }}" data-product-id="{{ $item->product_id }}">
                    <i class="fa-solid fa-xmark text-primary"></i>
                </a>
                <div class="ms-2">
                    <a href="{{ route('shop#productDetails', $item->product->id) }}" title="See product details">
                        <h6 class="my-0">{{ $item->product->name }}</h6>
                    </a>
                    <small class="text-body-secondary">{{ number_format($item->product->price) }} MMK</small>
                </div>
            </div>
            <form action="{{ route('user#addToCart') }}" method="post"
                class="d-flex align-items-center offcanvas-add-to-cart">
                @csrf
                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                <input type="hidden" name="productId" value="{{ $item->product->id }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit" title="Add to Cart" class="border-0 bg-transparent">
                    <i class="fa-solid fa-cart-plus text-primary"></i>
                </button>
            </form>
        </li>
    @empty
        <li class="list-group-item text-center text-muted" id="emptyWishlistMsg">
            No items in wishlist
        </li>
    @endforelse
@else
    <li class="list-group-item text-center text-muted">
        <a href="{{ route('login') }}?redirect={{ url()->current() }}">Log in</a> to see your wishlist.
    </li>
@endauth
