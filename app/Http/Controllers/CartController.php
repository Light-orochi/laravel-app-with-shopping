<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("cart.index");
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { $data = $request->json()->all();

        $duplicata=Cart::search(function ($cartItem, $rowId) use($data) {
            return $cartItem->id == $data['product_id'];
        });

        if ($duplicata->isNotEmpty()){
            return response()->json(['status'=>0,'message' => 'le produit existe déja dans votre  panier']);

        }

        $product=Product::find($data['product_id']);
       Cart::add($data['product_id'],$product->title,1,$product->price)
                ->associate('App\Product');

        return response()->json(['status'=>1,'message' => 'votre  produit à bien été ajouter dans votre  panier merci','qty'=>Cart::count()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {

    Cart::remove($rowId);
    return back()->with('success','le produit a ete supprimer');

    }
}
