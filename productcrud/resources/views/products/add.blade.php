<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
          <style>
            .invalid-feedback {
                display: none;
            }

            .is-invalid + .invalid-feedback {
                display: block;
            }
            </style>
        <h2>Add New Product</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>
        @error('name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" step="0.01" required>
        @error('price')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group pb-3">
        <label for="images">Images</label>
        <input type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" multiple required>
        @error('images')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
        @enderror
        @error('images.*')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Add Product</button>
</form>


    </div>
@endsection
