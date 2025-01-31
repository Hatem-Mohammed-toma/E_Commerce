<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

   public function all(){

     $categories = Category::all();
     return view('Categories.all',compact("categories"));
    }
    public function show($id){

         $category=  Category::findorfail($id); /////
         return view('Categories.show',compact("category"));
    }
    public function create(){
        return view('Categories.create');
    }


    public function store(Request $request){  // انا هنا مفروض بدخل الداتا بتاعتي


       $data = $request->validate([
             "name"=>"required|string|max:255",
             "desc"=>"required|string",
         ]);

      Category::create($data);
         // sesssion لو عاوز اابعت رساله flash / put (من غير متعمل unset session )
         session()->flash("success","data inserted successfully ");

        // redirect // route=>url الروت بتاع الجزء الخاص ب كل الكاتيجوريز
         return redirect(url('categories')); // all categories

    }

    public function edit($id){ // انا هنا بمسك ال الكاتيجوري وروح اعرضو في صفحه ال فورم
     $category = Category::findOrfail($id);
     return view('Categories.edit',compact("category"));
    }

    public function update($id ,Request $request){
      // catch request    // validate // catch موجود ولا لا  // create

      $data =   $request->validate([
              "name"=>"required|string|max:255",
             "desc"=>"required|string",
         ]);

         $category = Category::findOrFail($id);

         $category->update($data);

         session()->flash("success","data updated successfully ");
         return redirect(url("categories/show/$id"));

    }
    public function delete($id){

        $category = Category::findOrFail($id);
         $category->delete();

     session()->flash("success","data deleted successfully ");
     return redirect(url('categories'));

    }

}
