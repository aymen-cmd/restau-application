<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        //
        return view('managment.tables.index')->with([

            "tables"=> Table::paginate(5)
            ]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('managment.tables.create');

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
           //validation
           $this->validate($request, [
            "name"=> "required|unique:tables,name",
            "status"=> "required|boolean"

         ]);

         $name = $request->name;
         Table::create([
             "name"=>$name,
             "slug"=> Str::slug($name), 
             "status"=> $request->status,

         ]);
         return redirect()->route("tables.index")->with([
             "success" => "Table ajoutee avec succee"
         ]);
        
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('managment.tables.edit')->with([
         "table"=>$table

        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {   
          //validation
        $this->validate($request, [
         "name"=> "required|unique:tables,name,".$table->id,
         "status"=> "required|boolean"

      ]);

      $name = $request->name;
      $table->update([
          "name"=>$name,
          "slug"=> Str::slug($name), 
          "status"=> $request->status,

      ]);
      return redirect()->route("tables.index")->with([
          "success" => "Table modifier avec succee"
      ]);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
          
         $table->delete([
            
   
         ]);
         return redirect()->route("tables.index")->with([
             "success" => "Table modifier avec succee"
         ]);
        //
    }
}
