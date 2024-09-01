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
                <small class="pt-1">{{ $product->reviews->count() }} reviews</small>
                <h3 class="font-weight-semi-bold mb-4">{{ $product->price_after_offer }}</h3>
                <p class="mb-4">{{ $product->description }}</p>
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price_after_offer }}">

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="number" name="quantity" class="form-control bg-secondary text-center" value="1" min="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </div>
                </form>
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
    <!-- Additional sections for description, information, and reviews -->
</div>
<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">You May Also Like</span>
    </h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($products as $product)
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ $product->image }}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('products.show', $product->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="{{ route('products.show', $product->id) }}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $product->price_after_offer }}</h5>
                                <h6 class="text-muted ml-2">
                                    <del>{{ $product->price_before_offer }}</del>
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
<!-- Place this at the bottom of your Blade file -->
<script>
    document.querySelectorAll('.btn-plus, .btn-minus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input[name="quantity"]');
            let value = parseInt(input.value, 10);

            if (this.classList.contains('btn-plus')) {
                value = isNaN(value) ? 1 : value + 1;
            } else if (this.classList.contains('btn-minus')) {
                value = isNaN(value) ? 1 : Math.max(1, value - 1);
            }

            input.value = value;
        });
    });
</script>

<x-footer />
