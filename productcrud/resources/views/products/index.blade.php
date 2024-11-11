@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Product List</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                <a href="{{ route('cart.view') }}" class="btn btn-primary">Cart View</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Images</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>${{ $product->price }}</td>
                            <td>
                                @foreach ($product->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail"
                                        width="100" height="100" />
                                @endforeach

                            </td>
                            <td>
                                <button class="btn btn-primary btn-cart" onclick="addToCart({{ $product->id }})">Add to
                                    Cart</button>
                                <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary btn-cart">Edit Product</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    function addToCart(productId) {
        fetch('/api/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Product added to cart');
            })
            .catch(error => console.error('Error:', error));
    }
</script>
