<x-head />
@foreach($products as $product)
    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
            <div class="product-img position-relative overflow-hidden">
                <img class="img-fluid w-100" src="{{ $product->image }}" alt="">
                <div class="product-action">
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                </div>
            </div>
            <div class="text-center py-4">
                <a class="h6 text-decoration-none text-truncate" href="products/{{ $product->id }}">{{ $product->name }}</a>

                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h5>{{ presentPrice($product->price_after_offer) }}</h5><h6 class="text-muted ml-2"><del>{{ presentPrice($product->original_price) }}</del></h6>
                </div>
                <div class="d-flex align-items-center justify-content-center mb-1">
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small>{{ $product->reviews->count() }}</small>
                </div>
                <div class="d-flex align-items-center justify-content-center mt-2">
                 {{--   <form action="{{ route('products.rate', $product->id) }}" method="post">
                        @csrf
                        <label for="rating">Rate:</label>
                        <select name="rating" id="rating">
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                        <button type="submit">Submit Rating</button>
                    </form>--}}

                    <!-- ... (repeat for other stars) ... -->
                </div>
            </div>
        </div>
    </div>
@endforeach
<x-footer />
