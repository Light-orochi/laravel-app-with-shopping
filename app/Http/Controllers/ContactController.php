<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request){
         $this->validate($request,[
              'nom'=>['required','string','max:100'],
              'email'=>['required','email'],
              'message'=>['required','string','max:1000']
          ]);
          Mail::to('lightorochi32@gmail.com')->send(new Contact($request->except('_token')));
          return back()->with('success','message envoyer avec succes ');
    }

}
