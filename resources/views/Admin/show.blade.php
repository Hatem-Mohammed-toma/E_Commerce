@extends('Admin.layout')



@section('body')


@include('success')

Product Name : {{$product->name}}<br>
Product desc : {{$product->desc}}<br>
Product price : {{$product->price}}<br>
Product quantity : {{$product->quantity}}<br>
Image : <br>
<img src="{{asset("storage/$product->image")}}" alt="" srcset=""> <br>

            <form action="{{url("products/$product->id")}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">delete</button>
            </form>
            <h1>
                <a class="btn btn-success" href="{{url("products/edit$product->id")}}">edit</a>
            </h1>

@endsection
