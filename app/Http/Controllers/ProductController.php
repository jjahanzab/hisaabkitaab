<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $response = array();
        $response['products'] = Product::paginate(10);
        return view('backend.products.index', $response);
    }

    public function create()
    {
        $response = array();
        $response['categories'] = Category::get();
        return view('backend.products.create', $response);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg|max:5000',
        ]);

        $product = new Product;
        if ($request->hasFile('pic')) {
            $pic = mt_rand(999999999, time()).'.'.$request->pic->extension();  
            $request->pic->move(public_path('uploads/products'), $pic);
            $product->pic = $pic;
        }

        $product->slug = random_int(1000000000, time());
        $product->category_id = (Int)$request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->product_code = $request->product_code ? $request->product_code : NULL;
        $product->manufacturer = $request->manufacturer ? $request->manufacturer : NULL;
        $product->supplier = $request->supplier ? $request->supplier : NULL;
        $product->description = $request->description ? $request->description : NULL;
        $product->status = $request->status == 'on' ? 'A' : 'I';

        if($product->save()) {
            return redirect()->back()->with(['successMessage'=>'New product created successfully.']);
        } else {
            return redirect()->back()->with(['errorMessage'=>'Error in product creation.']);
        }
    }

    public function edit($slug)
    {
        $response = array();
        $response['categories'] = Category::get();
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            $response['product'] = $product;
            return view('backend.products.edit', $response);
        } else {
            return redirect()->back()->with(['errorMessage'=>'Product not exists']);
        }
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg|max:5000',
        ]);

        $product = Product::where('slug', $request->slug)->first();

        if ($product) {
            
            if ($request->hasFile('pic')) {
                $pic = mt_rand(999999999, time()).'.'.$request->pic->extension();  
                $request->pic->move(public_path('uploads/products'), $pic);

                if(!empty($product->pic) && !empty($pic)) {
                    if (file_exists(public_path('uploads/products/'. $product->pic))) {
                        unlink(public_path('uploads/products/'. $product->pic));
                    }
                }
                $product->pic = $pic;
            }

            $product->category_id = (Int)$request->category_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->product_code = $request->product_code ? $request->product_code : NULL;
            $product->manufacturer = $request->manufacturer ? $request->manufacturer : NULL;
            $product->supplier = $request->supplier ? $request->supplier : NULL;
            $product->description = $request->description ? $request->description : NULL;
            $product->status = $request->status == 'on' ? 'A' : 'I';

            if($product->save()) {
                return redirect()->back()->with(['successMessage'=>'Product updated successfully.']);
            } else {
                return redirect()->back()->with(['errorMessage'=>'Error in product updation.']);
            }

        } else {
            return redirect()->back()->with(['errorMessage'=>'Product not exists']);
        }

    }

    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            if(!empty($product->pic)) {
                if (file_exists(public_path('uploads/products/'. $product->pic))) {
                    unlink(public_path('uploads/products/'. $product->pic));
                }
            }
            if($product->delete()) {
                return redirect()->back()->with(['successMessage'=>'Product deleted successfully.']);
            } else {
                return redirect()->back()->with(['errorMessage'=>'Error in product deletion.']);
            }
        } else {
            return redirect()->back()->with(['errorMessage'=>'Product not exists']);
        }
    }
}

