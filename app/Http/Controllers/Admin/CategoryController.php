<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categoryrequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::query()->paginate(10);
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isUpdate=false;
        $categorie=new Category();
        return view('category.form',compact('categorie','isUpdate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Categoryrequest $request)
    {
        $formfields=$request->validated();
        Category::create($formfields);
        return to_route('categories.index')->with('success','category create succsess');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $products=$category->products()->get();
        return view('category.show',compact('category','products'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $isUpdate=true;
        return view('category.form',compact('category','isUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Categoryrequest $request, Category $category)
    {
        $category->fill($request->validated())->save();
        return to_route('categories.index')->with('success','nice update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('categories.index')->with('success','delete');
    }
}
