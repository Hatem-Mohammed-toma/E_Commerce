@extends('User.layout')

@section('latest')
<div class="latest-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Latest Products</h2>

                    <form action="{{url('search')}}" method="get">
                        <input type="text" name="key" value="{{ old('key') }}" class="form-control">
                        <button type="submit" class="btn btn-info mt-2">Search</button>
                    </form>
                    @include('success')
                    <a href="products.html">View all products <i class="fa fa-angle-right"></i></a>
                </div>
            </div>

            @foreach ($products as $product)
            <div class="col-md-4">
                <div class="product-item">
                    <a href="#"><img src="{{ asset('storage/' . $product->image) }}" alt=""></a>
                    <div class="down-content">
                        <a href="{{ url('products/' . $product->id) }}"><h4>{{ $product->name }}</h4></a>
                        <h6>${{ $product->price }}</h6>

                        {{-- Display the category name --}}
                        <p>Category: {{ $product->category->name ?? 'No Category' }}</p>

                        <form action="{{ url("addToCart/$product->id") }}" method="post">
                            @csrf
                            <input type="number" name="qty" id="">
                            <button type="submit" class="btn btn-info m-2">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
