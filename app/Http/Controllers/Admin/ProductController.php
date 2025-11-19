<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //direct to product list page
    public function product($action = "default"){
        $product = Product::select('products.id','products.name','products.image','products.price','products.stock','products.category_id','categories.name as category_name')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->orderBy('products.created_at','desc')
                        ->when($action == 'lowStock',function($query){
                            $query->where('products.stock','<=',3);
                        })
                        ->when(request('searchKey'),function($query){
                            $query->whereAny(['products.name','products.price','categories.name'], 'like' , '%'.request('searchKey').'%' );
                        })
                        ->paginate(5);

        return view('admin.product.list',compact('product'));
    }

    //direct to product create page
    public function createProductPage(){
        $category = Category::get();
        return view('admin.product.create',compact('category'));
    }

    //create product
    public function createProduct(Request $request){
        $this->checkValidation($request,'create');
        $data = $this->getData($request);

        if($request->hasFile('image')){
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path()."/productImage/",$fileName);
            $data['image'] = $fileName;
        }

        Product::create($data);

        return back()->with('create','Product created successfully!');
    }

    //direct to update page
    public function edit($id){
        $category = Category::get();
        $product = Product::where('id',$id)->first();
        return view('admin.product.edit',compact('category','product'));
    }

    //update product
    public function update(Request $request){
        $this->checkValidation($request,'update');
        $data = $this->getData($request);

        if($request->hasFile('image')){
            $oldImageName = $request->productImage;

            if(file_exists(public_path('productImage/'.$oldImageName))){
                unlink(public_path('productImage/'.$oldImageName));
            }

            $fileName = uniqid(). $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path()."/productImage/".$fileName);
            $data['image'] = $fileName;
        }else{
            $data['image'] = $request->productImage;
        }

        Product::where('id',$request->productId)->update($data);

        return to_route('admin#product')->with('update','Product updated successfully!');
    }

    //get product data
    public function getData($request){
        return [
            'name' => $request->name,
            'category_id' => $request->categoryId,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];
    }

    //delete product
    public function deleteProduct($id,$image){
        if(file_exists(public_path('productImage/'.$image))){
                 unlink(public_path('productImage/'.$image));
            }

        Product::where('id',$id)->delete();
        return back()->with('delete','Product deleted successfully!');
    }

    //check validation
    private function checkValidation($request,$action){
        $rules = [
            'name' => 'required|min:1|max:50|unique:products,name,'.$request->productId,
            'categoryId' => 'required',
            'price' => 'required|numeric|min:2',
            'stock' => 'required|numeric|max:999',
            'description' => 'required|max:2000'
        ];

        $rules['image'] = $action == 'create' ? 'required|file:mimes:png,jpg,jpeg,webp,svg,gif': 'file|mimes:png,jpg,jpeg,webp,svg,gif';

        $message = [
            'categoryId.required' => 'Category field is required'
        ];

        $request->validate($rules,$message);
    }
}
