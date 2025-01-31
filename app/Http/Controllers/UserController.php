<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function all()
    {
        $products = Product::all();
        // dd($products);
        return view('User.home', compact('products'));
    }

      public function show($id){
        $product = Product::findOrfail($id);
        $categoryID = $product->category_id ;
        $category= Category::findOrFail($categoryID);
        return view('User.show',compact("product","category"));

      }
public function search(Request $request){
    $key = $request->key ;
    $products = Product::where('name','like',"%$key%")->get() ;
    return view('User.home', compact('products'));

}

public function addToCart($id , Request $request)
   {
     $product =  Product::findOrFail($id);
     $qty = $request->qty;
     if(! $product)
     {
        abort(404);
     }
     $cart = session()->get("cart");

     session_unset() ;
     if(! $cart)
     {
       $cart = [
        $id => [
            "name"=>$product->name,
            "qty"=>$qty,
            "price"=>$product->price,
            "image"=>$product->image,
        ]
       ];
       session()->put("cart",$cart);
    //    dd(session()->get("cart"));
       return redirect()->back()->with("success","product addedd to cart successfuly");
     }else {
        if(isset($cart[$id])) {
            $oldqty = $cart[$id]["qty"];

                    $cart[$id]['qty'] = $oldqty + $qty ;
                    session()->put('cart', $cart);
                    // dd(session()->get("cart"));
                    return redirect()->back()->with('success', 'Product added to cart successfully!');
         }else{
             $cart[$id] = [
                 "name"=>$product->name,
                 "qty"=>$qty,
                 "price"=>$product->price,
                 "image"=>$product->image,
                ];
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Product added to cart successfully!');
                // dd(session()->get("cart"));
            }
     }
   }
   public function mycart()
   {
    $products  = session()->get("cart");
    $user = Auth::user();
    // dd($products);
    return view("User.mycart")->with("products",$products)->with("user",$user);
   }
   public function makeOrder(Request $request)
   {
    $products  = session()->get("cart");
    $user = Auth::user();
    $requiredDate = $request->day;
    $orderDate = now(); // Use the current date for the order date

    // Create the order
    $order = Order::create([
        "orderDate" => $orderDate,
        "requiredDate" => $requiredDate,
        "user_id" => $user->id,
    ]);
    foreach($products as $id=>$data){
        OrderDetails::create([
            "order_id"=>$order->id,
            "product_id"=>$id,
            "qty"=>$data['qty'],
            "price"=>$data['price']
        ]);
    }
return redirect(url(""))->with('success', 'Product added to cart successfully!');
   }
}