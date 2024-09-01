<x-head />
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"></script>

<x-breadcrumbs title="Shopping Cart" />

<!-- Cart Start -->
<div class="container-fluid">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                <tr>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody class="align-middle">
                @if(Cart::count() > 0)
                    @foreach(Cart::content() as $item)
                        <tr>
                            <td class="align-middle">
                                <img src="{{ $item->model->image }}" alt="" style="width: 50px;">
                                <a href="{{ route('products.show', [$item->id]) }}">{{ $item->model->name }}</a>
                            </td>
                            <td class="align-middle">{{ '$'. number_format($item->model->price_after_offer, 2) }}</td>
                            <td class="align-middle">
                                <select class="quantity" data-id="{{ $item->rowId }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option {{ $item->qty == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                            <td class="align-middle">{{ '$'. number_format($item->model->price_after_offer * $item->qty, 2) }}</td>
                            <td class="align-middle">
                                <form method="POST" action="{{ route('cart.destroy', $item->rowId) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No Items Found!</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <div class="col-lg-4">
            @if(!session()->has('coupon'))
                <form class="mb-30" action="{{ route('coupon.store') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="code" id="code" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
            @endif
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Cart Summary</span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subtotal">{{ presentPrice(Cart::subtotal()) }}</h6>
                    </div>

                    @if(session()->has('coupon'))
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Discount ({{ session()->get('coupon')['name'] }}) :</h6>
                            <h6 id="discount">-{{ presentPrice($discount) }}</h6>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <h6>New Subtotal</h6>
                            <h6 id="newSubtotal">{{ presentPrice($newSubtotal) }}</h6>
                        </div>

                        <div class="d-flex justify-content-between">
                            <h6>Tax</h6>
                            <h6 id="newTax">{{ presentPrice($newTax) }}</h6>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="newTotal">{{ presentPrice($newTotal) }}</h5>
                        </div>
                    @else
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Tax</h6>
                            <h6 id="newTax">{{ presentPrice(Cart::tax()) }}</h6>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="newTotal">{{ presentPrice(Cart::total()) }}</h5>
                        </div>
                    @endif

                    <a href="{{ route('checkout.index') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<x-footer/>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    (function(){
        const quantityElements = document.querySelectorAll('.quantity');

        quantityElements.forEach(function(element) {
            element.addEventListener('change', function () {
                const id = element.getAttribute('data-id');
                const quantity = parseInt(element.value, 10); // Ensure quantity is an integer

                axios.patch(`/cart/${id}`, { quantity: quantity })
                    .then(function (response) {
                        // Update cart summary on the page
                        document.querySelector('#subtotal').innerText = response.data.subtotal;
                        document.querySelector('#discount').innerText = response.data.discount;
                        document.querySelector('#newSubtotal').innerText = response.data.newSubtotal;
                        document.querySelector('#newTax').innerText = response.data.newTax;
                        document.querySelector('#newTotal').innerText = response.data.newTotal;
                    })
                    .catch(function (error) {
                        console.log(error);
                        window.location.href = '{{ route('cart.index') }}';
                    });
            });
        });
    })();
</script>
