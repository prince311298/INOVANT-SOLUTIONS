<!-- resources/views/cart/view.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2>Cart</h2>

            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products list</a>
        </div>
        @if (count($cartItems) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th style="width:20%">Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>
                                    <input type="number" class="form-control quantity-update"
                                        data-cart-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1" style="width:70%">
                                </td>
                                <td>Rs. {{ $item->product->price }}</td>
                                <td>Rs. {{ $item->product->price * $item->quantity }}</td>
                                <td>
                                    <button class="btn btn-danger remove-from-cart" data-cart-id="{{ $item->id }}">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @else
            <p>No items in cart.</p>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            // Update quantity 
            $('.quantity-update').on('change', function() {
                var cartId = $(this).data('cart-id');
                var quantity = $(this).val();

                if (quantity > 0) {
                    $.ajax({
                        url: '/cart/update/' + cartId,
                        method: 'PUT',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            quantity: quantity,
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Quantity updated successfully');
                                location.reload();
                            } else {
                                alert('Error updating quantity');
                            }
                        },
                        error: function() {
                            alert('An error occurred. Please try again.');
                        }
                    });
                } else {
                    alert('Please enter a valid quantity.');
                }
            });

            // Remove item from cart
            $('.remove-from-cart').on('click', function() {
                var cartId = $(this).data('cart-id');

                if (confirm('Are you sure you want to remove this item from the cart?')) {
                    $.ajax({
                        url: '/cart/remove/' + cartId,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.success) {
                                alert('Item removed from cart');
                                location.reload();
                            } else {
                                alert('Error removing item from cart');
                            }
                        },
                        error: function() {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
