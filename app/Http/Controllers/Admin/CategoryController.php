<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //direct to category page
    public function category(){
        $category = Category::orderBy('created_at','desc')->paginate(5);

        return view('admin.category.list',compact('category'));
    }

    //create category
    public function createCategory(Request $request){
        $this->checkValidation($request);

        Category::create([
            'name' => $request->categoryName
        ]);

        return back()->with('create', 'Category created successfully!');
    }

    //delete category
    public function deleteCategory($id){
        Category::where('id',$id)->delete();

        return back()->with('delete', 'Category deleted successfully!');

    }

    //update category page
    public function updateCategoryPage($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    public function updateCategory(Request $request, $id){
        $this->checkValidation($request);

        Category::where('id',$id)->update([
            'name' => $request->categoryName
        ]);

        return to_route('admin#category')->with('update', 'Category updated successfully!');
    }

    //check validation
    private function checkValidation($request){
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name,'.$request->id
        ],[
            'categoryName.required' => 'Category name is required'
        ]);
    }

}
