<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\Product;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\Cart; // Import Cart facade
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class CartController extends Controller
{
    public function index(){
        return view('cart.index')->with([
            "items" => \Cart::getContent()
        ]);
    }

    //add item to cart
    public function addProductToCart(Request $request, Product $product)
    {
        


        \Cart::add(array(
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "quantity" =>  $request->input('qty', 1),
            "attributes" => array(),
            "associatedModel" => $product,
        ));
        
        return redirect()->route("cart.index");
    }

     //update item on cart
     public function updateProductOnCart(Request $request, Product $product)
     {
         \Cart::update($product->id, array(
             'quantity' => array(
                 'relative' => false,
                 'value' => $request->qty
             ),
         ));
         return redirect()->route("cart.index");
     }

      //remove item from cart
    public function removeProductFromCart(Product $product)
    {
        \Cart::remove($product->id);
        return redirect()->route("cart.index");
    }

    public function getOrder(Request $request){

        foreach (\Cart::getContent() as $item) {
            order::create([
                "user_id" => FacadesAuth::user()->id,
                "product_name" => $item->name,
                "qty" => $item->quantity,
                "price" => $item->price,
                "total" => $item->quantity*$item->price,
                "paid" => 0,
                'adress'=>$request->adress,
                'phone'=>$request->phone,
                'getTotale'=>$request->getTotale,

            
            ]);
            
            \Cart::clear();
        }
        return redirect()->route('cart.index')->with([
            'success' => 'Paid successfully'
        ]);
    }
}
