<?php

namespace App\Http\Controllers;

use App\Order;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()

    {
        $client_id='ASPw3pHUeWXwbmSTLVGYG4-XG_8_B6vdain4hbKolNeXlCshQtJZa9bFXZc3mFcVPC69dNx6wclmQ6SI';
        return view('checkout.index',compact('client_id'));
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
    {
        $data = $request->json()->all();



        $products = [];
        $i = 0;

        foreach (Cart::content() as $product) {
            $order = new Order();


        $order->payment_intent_id = $data['details']['id'];
        $order->amount = $data['details']['purchase_units'][0]['amount']['value'];

        $order->payment_created_at = (new DateTime())
            ->format('Y-m-d H:i:s');
        $order->products=$product->model->title;
        $order->products_id=$product->model->id;
        $order->user_id = Auth::id();
         $order->save();
        }






        if ($data['details']['purchase_units'][0]['payments']['captures'][0]['status']=== 'COMPLETED') {
            Cart::destroy();
            Session::flash('success', 'Votre commande a été traitée avec succès.');
            return response()->json(['success' => 'Payment Intent Succeeded']);
        } else {
            return response()->json(['error' => 'Payment Intent Not Succeeded']);
        }
    }

    public function thankyou()
    {
        return  view('checkout.thankYou');
         return Session::has('success') ? view('checkout.thankYou') : redirect()->route('boutique.index');
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
    public function destroy($id)
    {
        //
    }
}
