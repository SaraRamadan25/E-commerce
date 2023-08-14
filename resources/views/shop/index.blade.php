<x-head />
<!-- Shop Sidebar Start -->
<div class="col-lg-3 col-md-4">
    <!-- Price Start -->
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
    <div class="bg-light p-4 mb-30">
        <form action="{{ route('shop.index') }}" method="get">
            <!-- Price filters here -->
            @foreach ($priceRanges as $range)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="custom-control-input" id="price-{{ $range['min'] }}-{{ $range['max'] }}" name="price" value="{{ $range['min'] }}-{{ $range['max'] }}" @if(request('price') === "{$range['min']}-{$range['max']}") checked @endif>
                    <label class="custom-control-label" for="price-{{ $range['min'] }}-{{ $range['max'] }}">${{ $range['min'] }} - ${{ $range['max'] }}</label>
                    <span class="badge border font-weight-normal">{{ $productCountsByPriceRange[$loop->index]['count'] }}</span>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>
    </div>
    <!-- Price End -->

    <!-- Color Start -->
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
    <div class="bg-light p-4 mb-30">
        <form action="{{ route('shop.index') }}" method="get">
            @foreach ($colors as $key => $color)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="custom-control-input" id="color-{{ $key }}" name="color[]" value="{{ $color }}">
                    <label class="custom-control-label" for="color-{{ $key }}">{{ $color }}</label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>
    </div>
    <!-- Color End -->

    <!-- Size Start -->
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
    <div class="bg-light p-4 mb-30">
        <form action="{{ route('shop.index') }}" method="get">
            @foreach ($sizes as $key => $size)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="custom-control-input" id="size-{{ $key }}" name="size[]" value="{{ $size }}">
                    <label class="custom-control-label" for="size-{{ $key }}">{{ $size }}</label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>
    </div>
    <!-- Size End -->
</div>



<div class="col-lg-9 col-md-8">
    <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                </div>
                <div class="ml-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Latest</a>
                            <a class="dropdown-item" href="#">Popularity</a>
                            <a class="dropdown-item" href="#">Best Rating</a>
                        </div>
                    </div>
                    <div class="btn-group ml-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">10</a>
                            <a class="dropdown-item" href="#">20</a>
                            <a class="dropdown-item" href="#">30</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
            <div class="product-item bg-light mb-4">
                <div class="product-img position-relative overflow-hidden">
                    <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                    <div class="product-action">
                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="text-center py-4">
                    @foreach($products as $product)
                        <a class="h6 text-decoration-none text-truncate" href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>{{ presentPrice($product->price_after_offer) }}</h5><h6 class="text-muted ml-2"><del>{{ presentPrice($product->original_price) }}</del></h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small>(99)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-12">
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
</div>
<!-- Shop Product End -->
</div>
</div>
<x-footer />
