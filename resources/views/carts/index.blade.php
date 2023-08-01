<x-head />

<x-breadcrumbs :title="'Shopping cart'" />

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Cart table here -->
    </div>
</div>
@foreach($products as $product)
    {{ $product->name }}

    <form action="{{ route('cart.store', $product->id) }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <input type="hidden" name="name" value="{{ $product->name }}">
        <input type="hidden" name="price" value="{{ $product->price }}">
        <!-- You can add other input fields or elements for quantity, etc. -->
        <button type="submit" class="btn btn-primary">Add to Cart</button>
    </form>
@endforeach


<!-- Cart End -->
<x-footer />
