<x-head />

<x-breadcrumbs :title="'Checkout'" />

@if (session()->has('success_message'))
    <div class="spacer"></div>
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
@endif

@if(count($errors) > 0)
    <div class="spacer"></div>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input name="mobile" class="form-control" type="text" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input name="address1" class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input name="address2" class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <select name="country" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <select name="city" class="form-control">
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <select name="state" class="form-control">
                            @foreach($states as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Create an account</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>

            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">
                    <h6 class="mb-3">Products</h6>
                    @foreach (Cart::content() as $item)
                        <div class="d-flex justify-content-between mb-3">
                            <h6>{{ $item->model->name }}</h6>
                            <h6> <img src="{{ $item->model->image }}" alt="Product Image" style="width: 50px;">
                            </h6>
                            <h6>{{ presentPrice($item->model->price_after_offer) }}</h6>
                        </div>
                    @endforeach
                </div>
                <div class="border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>   {{ (Cart::subtotal()) }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Tax</h6>
                        <h6 class="font-weight-medium">{{ Cart::tax() }}</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>{{ Cart::total() }}</h5>
                    </div>
                </div>
            </div>

        <form action="{{ route('payment.store') }}" method="POST" id="payment-form">
            @csrf
            <div class="mb-3">
                <label for="card-name" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Your name</label>
                <input type="text" name="name" id="card-name" class="border-2 border-gray-200 h-11 px-4 rounded-xl w-full">
            </div>
            <div class="mb-3">
                <label for="email" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Email</label>
                <input type="email" name="email" id="email" class="border-2 border-gray-200 h-11 px-4 rounded-xl w-full">
            </div>
            <div class="mb-3">
                <label for="payment-method" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Payment Method</label>
                <div>
                    <input type="radio" name="payment_method" id="card" value="card" checked>
                    <label for="card">Credit Card</label>
                </div>
                <div>
                    <input type="radio" name="payment_method" id="paypal" value="paypal">
                    <label for="paypal">PayPal</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="card" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Card details</label>
                <div class="bg-gray-100 p-6 rounded-xl">
                    <div id="card-element"></div>
                </div>
            </div>
            <a href="{{ route('payment.store') }}"><button type="submit" class="w-full bg-indigo-500 uppercase rounded-xl font-extrabold text-white px-6 h-12">Pay 👉</button></a>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
            }
        });

        if (error) {
        } else {
            const paymentMethodInput = document.createElement('input');
            paymentMethodInput.setAttribute('type', 'hidden');
            paymentMethodInput.setAttribute('name', 'payment_method');
            paymentMethodInput.setAttribute('value', paymentMethod.id);
            form.appendChild(paymentMethodInput);

            form.submit();
        }
    });
</script>


<x-footer />
