<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categorie=null)
    {
        $productG=Product::inRandomOrder()->where('type','grand')->get();

        $products=$categorie ?Product::inRandomOrder()->where('type','petit')->where('version',$categorie)->take(24)->get():Product::inRandomOrder()->where('type','petit')->take(24)->get();


        //$plans=Product::inRandomOrder()->where('type','plan')->take(12)->get();
        return view('products.index',compact('products','productG'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

    }
    public function livres()
    {



        $product=Order::where('user_id',Auth::id())->latest()->get();
        $book=array();

        foreach ($product as $products){

            $id=$products->products_id;
           $item=Product::where('id',$id)->get();
           foreach($item as $books){
           $book[]=$books;

          }
        }




    return view('auth.livres',compact('book'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\$slug and filter
     * @return \Illuminate\Http\Response
     */
    public function showAll($slug,$filter=null,$version)
    {
      if ($slug AND $filter=='tout' AND $version){
        $products = Product::inRandomOrder()->where('type',$slug)->where('version',$version)->paginate(18);
        return view('products.all',compact('products','slug','version'));
      }

    //   else if ($slug AND $filter){
    //     $products = Product::inRandomOrder()->where('type','plan')->paginate(18);
    //     return view('products.all',compact('products','slug'));
    //   }

      else if($slug AND $filter AND $version){
        $products = Product::inRandomOrder()->where('categorie',$filter)->where('type',$slug)->where('version',$version)->paginate(18);
        return view('products.all',compact('products','slug','version'));
     }
    //   else if($slug=='plan' AND $filter){
    //     $products = Product::inRandomOrder()->where('categorie',$filter)->where('type','plan')->paginate(18);
    //     return view('products.all',compact('products','slug'));
    //   }
      else{
        $products = Product::inRandomOrder()->where('type',$slug)->where('version',$version)->paginate(18);
        return view('products.all',compact('products','slug','version'));
    }




    }
}
