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

    @if(count($errors)>0)
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
                <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

                <tbody class="align-middle">
                @foreach(Gloudemans\Shoppingcart\Facades\Cart::content() as $item)
                    <tr>
                        <td class="align-middle"><img src="{{ $item->model->image }}" alt="" style="width: 50px;"> <a href="{{ route('product.show',[$item->id]) }}">{{ $item->model->name }}
                            </a>
                        </td>
                        <td class="align-middle">{{'$'. number_format( $item->model->price_after_offer, 2 ) }}</td>
                        <td class="align-middle">
                            <select class="quantity" data-id="{{ $item->rowId }}">
                                @for ($i = 1; $i < 5 + 1 ; $i++)
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
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-30" action="{{ route('coupon.store') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3"><span
                    class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>{{ Cart::subtotal() }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">{{ Cart::tax() }}</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>{{ Cart::total() }}</h5>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout </a>
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
        const classname = document.querySelectorAll('.quantity')

        Array.from(classname).forEach(function(element) {
            element.addEventListener('change', function () {
                const id = element.getAttribute('data-id');
                const quantity = element.value;
                axios.patch(`/cart/${id}`, {
                    quantity: quantity
                })
                    .then(function (response) {
                        console.log(response);
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch(function (error) {
                        console.log(error);
                        window.location.href = '{{ route('cart.index') }}'
                    });
            });
        });

    })();

</script>

</script>
