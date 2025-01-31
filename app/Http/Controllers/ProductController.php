<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function allProducts(){

      $products = Product::all();
      return view('Admin.all',compact("products"));

    }

    public function show($id){
        $product = Product::findOrfail($id);
        return view('Admin.show',compact("product"));

      }

    public function create(){
        $categories= Category::all();
        return view('Admin.create',compact("categories"));
    }

    public function store(Request $request){
        // validation
    $data = $request->validate([
        "name"=>"required|string|max:255",
        "desc"=>"required|string",
        "image"=>"required|image|mimes:png,jpg,jpeg",
        "price"=>"required|numeric",
        "quantity"=>"required|integer",
        "category_id"=>"required|exists:categories,id",
    ]);

        //storage
  $data['image']= Storage::putFile("products",$data['image']);
        // create
    Product::create($data);
        // redirect form

    return redirect(url("products/create"))->with("success","data inserted successfuly");
    }

    public function edit($id){
        $product= Product::findOrfail($id);
        $categories= Category::all();
        return view('Admin.edit',compact("product","categories"));
    }

    public function update(Request $request,$id){
        // validation
        $product= Product::findOrfail($id);

    $data = $request->validate([
        "name"=>"required|string|max:255",
        "desc"=>"required|string",
        "image"=>"image|mimes:png,jpg,jpeg",
        "price"=>"required|numeric",
        "quantity"=>"required|integer",
        "category_id"=>"required|exists:categories,id",
    ]);


    // if ($request->has("image")) {
    //     if (!empty($book->image)) {
    //         Storage::delete($book->image);
    //     }
    //     $data['image'] = Storage::putFile("books", $data['image']);
    // }

 
    if($request->has("image")){
        if(!empty($product->image)){
            Storage::delete($product->image);
        }
        $data['image']= Storage::putFile("products",$data['image']);
    }

    $product->update($data);
        // redirect form
    return redirect(url("products/show/$id"))->with("success","data updated successfuly");
    }

    public function delete($id){
        $product = Product::findOrfail($id);
        Storage::delete($product->image);
        $product->delete();
      //  $products=Product::all();
      //  return view('Admin.all',compact("products"))->with("success","product deleted successfuly");
    return redirect(url("products"))->with("success","product deleted successfuly");
    }


}
