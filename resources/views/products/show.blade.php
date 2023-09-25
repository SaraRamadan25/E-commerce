@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; border-color: #c3e6cb; padding: 10px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
<x-head />
<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">

                        <img class="w-100 h-100" src="{{ $product->image }}" alt="Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3>{{ $product->name }}</h3>

                    <small class="pt-1">{{ $product->reviews->count() }}</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">{{ $product->price_after_offer }}</h3>
                <p class="mb-4">{{ $product->description }}</p>
                <div class="d-flex mb-3">
                    <strong class="text-dark mr-3">Sizes:</strong>
                    <form>
                        @php
                            $sizes = json_decode($product->sizes, true);
                            $size = $sizes['size'] ?? null;
                        @endphp
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-1" name="size">
                            @if(!empty($size))
                                <label class="custom-control-label" for="size-1">{{ $size }}</label>
                            @else
                                <p>Size not available</p>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="d-flex mb-4">
                    <strong class="text-dark mr-3">Colors:</strong>
                    <form>
                        @php
                            $colors = json_decode($product->colors, true);
                            $color = $colors['color'] ?? null;
                        @endphp
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-1" name="color">
                            @if(!empty($color))
                                <label class="custom-control-label" for="color-1">{{ $color }}</label>
                            @else
                                <p>Color not available</p>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    <form action="{{ route('cart.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price_after_offer }}">
                        <button type="submit" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart
                        </button>
                    </form>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews ({{ $product->reviews->count() }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{{ $product->description }}</p>

                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>{{{ $product->details }}}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ $product->reviews->count() }} review for "{{ $product->name }}"</h4>
                                @foreach($product->reviews as $review)
                                    <div class="media mb-4">
                                        <img src="{{ $review->user->image }}" alt="Image" class="img-fluid mr-3 mt-1"
                                             style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>{{ $review->created_at->diffForHumans() }}</i></small></h6>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                                <form action="{{ route('review.store', $product->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea name="review" id="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input name="username" type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input name="email" type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="rate">Your rate *</label>
                                        <div class="starability-basic">
                                            <input type="radio" id="rate-1" name="rate" value="1">
                                            <label for="rate-1" title="Terrible">1 star</label>

                                            <input type="radio" id="rate-2" name="rate" value="2">
                                            <label for="rate-2" title="Not Good">2 stars</label>

                                            <input type="radio" id="rate-3" name="rate" value="3">
                                            <label for="rate-3" title="Average">3 stars</label>

                                            <input type="radio" id="rate-4" name="rate" value="4">
                                            <label for="rate-4" title="Good">4 stars</label>

                                            <input type="radio" id="rate-5" name="rate" value="5">
                                            <label for="rate-5" title="Excellent">5 stars</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span>
    </h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($products as $product)
                    <div class="product-item bg-light">
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
                            <a class="h6 text-decoration-none text-truncate" href="">{{ $product->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $product->price_after_offer }}</h5>
                                <h6 class="text-muted ml-2">
                                    <del>{{ $product->price_after_offer }}</del>
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->

<x-footer />
