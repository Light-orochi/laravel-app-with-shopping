<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Rules\MinWordsRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(){
       $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug=null)
    {
         if($slug){
            $post=Post::where('categorie',$slug)->orderBy('created_at', 'DESC')->paginate(14);
            return view('posts.index',compact('post'));  
         }
         else{
              $post=Post::orderBy('created_at', 'DESC')->paginate(14);
             return view('posts.index',compact('post'));
      
         }
       
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {   
       
      $request['slug']=str_replace(' ', '-', $request['title']);
        Post::create([
            'title' => $request['title'],
            'slug'=>$request['slug'],
            'description'=>$request['description'],
            'image' => $request->image->store(config('image.path'), 'public'),
            'categorie'=>$request['categorie'],
            'user_id'=> Auth::id(),
            
        ]);
        return redirect()->route('post.index')->with('success','votre produit a bien été ajouté a la boutique de fournisseurs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $item)
    {
        $user=$item->user->name;
         return view('posts.show',compact('item','user'));
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $item)
    {
        return view('posts.edit',compact('item'));
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
       $this->validate($request,[
           'title'=>['bail','required','between:5,40'],
           'slug'=>'',
           'description'=>['bail','required',new MinWordsRule()],
           'categorie'=>['required']
      ]);
      $request['slug']=str_replace(' ', '-', $request['title']);
      $post=Post::where('id',$id)->firstOrFail();
  
      $post->update([
        'title' => $request['title'],
        'slug'=>$request['slug'],
        'description'=>$request['description'],
        'categorie'=>$request['categorie'],
      ]
         
      );

      return redirect()->route('post.index')->with('success','le produit a bien été modifier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::where('id',$id)->firstOrFail();
        $post->delete();
        return redirect()->route('post.index')->with('success','le produit a bien été supprimer');
    }
    
}
