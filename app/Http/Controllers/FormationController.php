<?php

namespace App\Http\Controllers;

use App\Mail\FormationMail;
use App\online;
use App\OrderO;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formation=online::get();

        return view('formation.index',compact('formation'));
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

         $data = $request->json()->all();


         $order = new OrderO();

        $order->payment_intent_id = $data['details']['id'];
        $order->amount = $data['details']['purchase_units'][0]['amount']['value'];

        $order->payment_created_at = (new DateTime())
            ->format('Y-m-d H:i:s');


        $order->products = $data['formation'];
        $order->user_id = Auth::id();
        $order->save();

        $details=[
                   'user'=>Auth::user()->name,
                   'email'=>Auth::user()->email,
                    'formation'=>$data['formation']
                  ];
                  Mail::to('lightorochi32@gmail.com')->send(new FormationMail($details));


        if ($data['details']['purchase_units'][0]['payments']['captures'][0]['status']=== 'COMPLETED') {

            Session::flash('success', 'Votre commande a été traitée avec succès.');
            return response()->json(['success' => 'Payment Intent Succeeded']);

        } else {
            return response()->json(['error' => 'Payment Intent Not Succeeded']);
        }

    }

    public function thankyou()
    {
        return Session::has('success') ? view('formation.thank') : redirect()->route('products.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(online $form)
    {

        return view('formation.show',compact('form'));
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
