<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index() {

        return view('admin.categories.categories-index');
    }

    public function destroy(Category $category) {
        $category->delete();

        return response()->noContent();
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.category-edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category) {
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . "." .$image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $image_name );
            $category->image = 'images/categories/' . $image_name;
            $category->save();
        }

        $category->update([
            'name'=> $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('status' , 'Category ' . $request->name . ' Updated successfully!');
    }

    public function create() {
        return view('admin.categories.category-create');
    }

    public function store(CreateCategoryRequest $request) {

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $image_name);
            $category->image = 'images/categories/' . $image_name;
            $category->save();
        }

        return redirect()->back()->with('status' , 'Category ' . $request->name . ' Has been created!');
    }
}
