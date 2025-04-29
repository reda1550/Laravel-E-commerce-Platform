<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\order;
use App\Models\Product;

use Illuminate\Http\Request;



class  StoreController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $orders=order::orderBy('user_id')->get();
        $items=\Cart::getContent();

        $productsQuery=Product::query();
        $name=$request->input('name');
        $categories=Category::with('products')->has('products')->get();
        $categoriesIDS=$request->input('categories');

        switch ($request->input('sort')) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            
            default:
                // pas de tri
                break;
        }
        if(!empty($name)){
            $productsQuery->where('name','like',"%{$name}%");

        }
        if(!empty($categoriesIDS)){
            $productsQuery->whereIn('category_id',$categoriesIDS);
        }
        $products=$productsQuery->get();
        return view('store.index',compact('products','categories','orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isUpdate=false;
        $product=new Product();
        return view('product.form',compact('product','isUpdate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $formsField=$request->validated();
        if($request->hasFile('image')){
            $formsField['image']=$request->file('image')->store('product','public');
        }
      
        Product::create($formsField);
       
        return to_route('products.index')->with('success','product create succsess');
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
      
        
        return view('store.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $isUpdate=true;
       
        return view('product.form',compact('product','isUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->validated())->save();
        return to_route('products.index')->with('success','nice update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('products.index')->with('success','product a ete supprimer');
    }
}
