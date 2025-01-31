<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    public function all(){
        // $products = Product::all();
        // return ProductResource::collection($products);
        $products = Product::all();
        $productsArray = [];

        foreach ($products as $product) {
            $productsArray[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'desc' => $product->desc,
                'image' => asset('storage') . '/' . $product->image,
            ];
        }
        return response()->json([
            'data' => $productsArray
        ]);
    }

    public function show($id){
        $product = Product::find($id);

        if($product == null){
           return response()->json([
                "msg"=>"Product not found"
           ],404);
        }
        return new ProductResource($product);
    }

    public function checkProductByName($name)
{


    $name = trim(strtolower($name));
    $product = Product::where("name","=",$name)->first();

    if (!$product) {
        return response()->json([
            'error' => 'Product not found.'
        ], 404);

    }else{
        $category = $product->category;
        return response()->json([
            'product_name' => $product->name,
            // "msg"=>"alternative",
            'category_name' => $category ? $category->name : 'No category',
            'category_desc' => $category ? $category->desc : 'No description'
        ]);


    }

    }


    public function store(Request $request){

      $validator = Validator::make($request->all(),[
        "name"=>"required|string|max:255",
        "desc"=>"required|string",
        "image"=>"required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480", // تمام تنفع صوره و فيديو
        "price"=>"required|numeric",
        "quantity"=>"required|integer",
        "category_id"=>"required|exists:categories,id",
       ]);

       if($validator->fails())
       {
        return response()->json([
            "errors"=>$validator->errors()
        ],301);
       }

       $imageName=Storage::putFile("products",$request->image);
      // Create
       Product::create([
        "name"=>$request->name,
        "desc"=>$request->desc,
        "price"=>$request->price,
        "quantity"=>$request->quantity,
        "image"=>$imageName,
        "category_id"=>$request->category_id,
       ]);

    // msg
         return response()->json([
             "msg"=>"Product added successfuly"
         ],201);
    }


    public function update(Request $request,$id)
    {
        
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "image"=>"image|mimes:png,jpg,jpeg",
            "price"=>"required|numeric",
            "quantity"=>"required|integer",
            "category_id"=>"required|exists:categories,id"
           ]);

           if($validator->fails())
           {
            return response()->json([
                "errors"=>$validator->errors()
            ],301);
           }
        // find
         $product = Product::find($id);
         if($product == null){
             return response()->json([
            "msg"=>"Product not found"
         ],404);
          }
    // storage
         $imageName = $product->image; // اسسم الصوره القديمهold
        if($request->has("image")){
            if($product->image !== null){
                Storage::delete($imageName);
            }
            $imageName=Storage::putFile("products",$request->image); // new
         }

    // update
         $product->update([
        "name"=>$request->name,
        "desc"=>$request->desc,
        "price"=>$request->price,
        "quantity"=>$request->quantity,
        "image"=>$imageName,
        "category_id"=>$request->category_id,
         ]);

    // msg
         return response()->json([
         "msg"=>"Product update successfuly",
         "product"=> new ProductResource($product)
      ],201);

    }


    public function delete($id)
    {

        $product = Product::find($id);

        if($product == null){
             return response()->json([
            "msg"=>"Product not found"
         ],404);
          }

          // storage
          if($product->image !== null){
            Storage::delete($product->image);
        }
          // delete
          $product->delete();
          // msg
          return response()->json([
            "success"=>"Product deleted successfuly"
         ],200);

    }
}
