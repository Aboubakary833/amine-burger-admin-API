<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commands_arr = Collection::unwrap(Command::where('status_id', '!=', 2)->where('status_id', '!=', 3)->get());
        $commands = [];
        foreach($commands_arr as $command) {
            $products_arr = $command->products;
            $products = [];
            foreach($products_arr as $product) {
                if(!in_array($product->uuid, array_keys($products))) {
                    $products[$product->uuid] = [
                        'product' => $product,
                        'number' => 1
                    ];
                } else {
                    $products[$product->uuid]['number'] += 1;
                }
            }
            array_push($commands, [
                'uuid' => $command->uuid,
                'created_at' => $command->created_at,
                'author' => $command->author,
                'products' => $products
            ]);
        }

        return view('commands', ['commands' => $commands]);
        
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
        //
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
        $command = Command::where('uuid', $id)->first();
        if(!$command) {
            return redirect()->back()->with('error', "La commande n'existe plus.");
        }
        $status_id = $request->status_id;
        if(!$status_id) {
            return redirect()->back()->with('error', "Il y'a eu une erreur!.");
        }

        $command->update(['status_id' => $status_id]);

        $success_message = $status_id == 2 ? "Commande rejétée avec succès!" : "Commande validée avec succès!";

        return redirect()->back()->with('success', $success_message);
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
