<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $response = array();
        $response['categories'] = Category::paginate(10);
        return view('backend.categories.index', $response);
    }

    public function create()
    {
        $response = array();
        return view('backend.categories.create', $response);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required'
        ]);
        
        $category = new Category;
        $category->slug = random_int(1000000000, time());
        $category->name = $request->name;
        $category->description = $request->description ? $request->description : NULL;

        if($category->save()) {
            return redirect()->back()->with(['successMessage'=>'New category created successfully.']);
        } else {
            return redirect()->back()->with(['errorMessage'=>'Error in category creation.']);
        }
    }

    public function edit($slug)
    {
        $response = array();
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $response['category'] = $category;
            return view('backend.categories.edit', $response);
        } else {
            return redirect()->back()->with(['errorMessage'=>'Category not exists']);
        }
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);

        $category = Category::where('slug', $request->slug)->first();

        if ($category) {
            $category->name = $request->name;
            $category->description = $request->description ? $request->description : NULL;

            if($category->save()) {
                return redirect()->back()->with(['successMessage'=>'Category updated successfully.']);
            } else {
                return redirect()->back()->with(['errorMessage'=>'Error in category updation.']);
            }

        } else {
            return redirect()->back()->with(['errorMessage'=>'Category not exists']);
        }

    }

    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            if($category->delete()) {
                return redirect()->back()->with(['successMessage'=>'Category deleted successfully.']);
            } else {
                return redirect()->back()->with(['errorMessage'=>'Error in category deletion.']);
            }
        } else {
            return redirect()->back()->with(['errorMessage'=>'Category not exists']);
        }
    }
}

