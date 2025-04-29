<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $products=Product::query()->paginate(10);
        return view('product.index',compact('products'));
      

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isUpdate=false;
        $product=new Product();
        $categories=Category::all();
        return view('product.form',compact('product','isUpdate','categories'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $isUpdate=true;
        $categories=Category::all();
       
        return view('product.form',compact('product','isUpdate','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $formsField=$request->validated();
       
        if($request->hasFile('image')){
            $formsField['image']=$request->file('image')->store('product','public');
        }
        $product->fill($formsField)->save();
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
    public function pannel(){
        $users=count(User::all()->where('role','=','user'));
        $sum=order::sum('total');
        $orders=count(order::all());
        $products= count( product::all());
        $categories=count(Category::all());
        return view('dashboard',compact('products','sum','users','orders','categories'));
    }

    public function showuser(){
        $users=User::all()->where('role','=','user');
        return view('showuser',compact('users'));
    }
}
