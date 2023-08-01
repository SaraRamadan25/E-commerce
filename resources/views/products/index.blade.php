<x-head />

<!-- Featured Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">All Products</span></h2>
    <div class="row px-xl-5">
        @foreach($products as $featured_product)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ $featured_product->image_url }}" alt="">
                        <form action="{{ route('cart.store') , $featured_product->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $featured_product->id }}">
                            <input type="hidden" name="name" value="{{ $featured_product->name }}">
                            <input type="hidden" name="price_after_offer" value="{{ $featured_product->price_after_offer }}">
                            <button type="submit" class="button button-plain"> Add To Cart</button>
                        </form>

                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{ $featured_product->name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{ $featured_product->presentOriginalPrice() }}</h5>
                            <h6 class="text-muted ml-2"><del>{{ $featured_product->presentPriceAfterOffer() }}</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star-half-alt text-primary mr-1"></small>
                            <small class="far fa-star text-primary mr-1"></small>
                            <small>({{ $featured_product->rate }})</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Featured Products End -->
<x-footer />
