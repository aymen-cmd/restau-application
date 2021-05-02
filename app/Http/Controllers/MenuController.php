<?php

namespace App\Http\Controllers;
use App\Category;
use App\menu;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(){

         $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("managment.menus.index")->with([
            'menus'=> Menu::paginate(5)   
            ]);     //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("managment.menus.create")->with([
            "categories" => Category::all()  
            ]);             
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //validation
         $this->validate($request, [
            "title"=> "required|min:3|max:20|unique:menus,title",
            "description"=> "required|min:5",
            "image"=> "required|image|max:2048",
            "price"=> "required|numeric",
            "category_id"=> "required|numeric",


         ]);
         if($request->hasFile('image')){
             $file = $request->image;
             $imageName = time() . "_" . $file->getClientOriginalName();
             $file->move(public_path('images/menus'),$imageName);
             $title = $request->title;
              Menu::create([
             "title"=>$title,
             "slug"=> Str::slug($title), 
             "description"=>$request->description,
             "price"=> $request->price, 
             "category_id"=> $request->category_id, 
             "image"=> $imageName, 

         ]);
         return redirect()->route("menus.index")->with([
             "success" => "categorie ajoutee avec succee"
         ]);
         }

        
        
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(menu $menu)
    {
        return view("managment.menus.edit")->with([
            "categories" => Category::all(),
            "menu" => $menu  
            ]);       
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, menu $menu)
    
    {
           //validation
           $this->validate($request, [
            "title"=> "required|min:3|unique:menus,title," . $menu->id,
            "description"=> "required|min:5",
            "image"=> "image|max:2048",
            "price"=> "required|numeric",
            "category_id"=> "required|numeric",


         ]);
         if($request->hasFile('image')){
             unlink(public_path('images/menus/' . $menu->image));
             $file = $request->image;
             $imageName = time() ."_" . $file->getClientOriginalName();
             $file->move(public_path('images/menus'), $imageName);
             $title = $request->title;
         Menu::create([
             "title"=>$title,
             "slug"=> Str::slug($title), 
             "description"=>$request->description,
             "price"=> $request->price, 
             "category_id"=> $request->category_id, 
             "image"=> $imageName, 

         ]);
         return redirect()->route("menus.index")->with([
             "success" => "categorie ajoutee avec succee"
         ]);
         }else{
            $title = $request->title;
            $menu -> update([
                "title"=>$title,
                "slug"=> Str::slug($title), 
                "description"=>$request->description,
                "price"=> $request->price, 
                "category_id"=> $request->category_id, 
            ]);
            return redirect()->route("menus.index")->with([
                "success" => "categorie modifier avec succee"
            ]);
         }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(menu $menu)
    {
        //
        unlink(public_path('images/menus/'. $menu->image));
       $menu->delete();
        return redirect()->route("menus.index")->with([
            "success" => "categorie supprimer avec succee"
        ]);

    }
}
