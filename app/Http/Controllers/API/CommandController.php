<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Command;
use App\Models\CommandsProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commmands = Command::with('products:name,price')->where('user_id', auth()->user()->id)->get();
        
        return response()->json($commmands);
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
        $products = json_decode($request->products, true);
        if(empty($products)) {
            return response()->json(['error' => "Votre panier est vide."], 401);
        }

        $command = Command::create([
            'uuid' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'status_id' => 1
        ]);

        foreach ($products as $product_uuid) {
            $product = Product::where('uuid', $product_uuid)->first();
            CommandsProduct::create([
                'command_id' => $command->id,
                'product_id' => $product->id
            ]);
        }

        return response()->json(['success' => "Vous venez de faire votre commande avec succès."]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $command = Command::where('uuid', $id)->first();
        if(!$command) return response()->json(['error' => "La commande n'existe pas!"]);
        Command::destroy($command->id);
        return response()->json(['success' => "La commande a été supprimé avec succès."]);
    }
}
