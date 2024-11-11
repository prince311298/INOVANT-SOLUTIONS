@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Edit Product: {{ $product->name }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Product list</a>
                <a href="{{ route('cart.view') }}" class="btn btn-primary">Cart View</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control"
                            value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="images">Upload New Product Images</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple>
                    </div>



                    <button type="submit" class="btn btn-primary mt-3">Update Product</button>
                </form>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="existing-images">Existing Images</label>
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image"
                                    class="img-fluid mb-2" width="100">
                                <form action="{{ route('product.images.destroy', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-1">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
