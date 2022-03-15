<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['products' => Product::all()]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        if($validator->failed()) {
            return redirect()->back()->with('error', "Il y'a eu une erreur lors de l'ajout! Veuillez réessayer.");
        }

        $inputs = $request->all(['name', 'description', 'price']);
        $inputs['uuid'] = Str::uuid();

        $file = $request->file('image');
        $fullPath = $file->store('public/products');
        $splited_path = explode('/', $fullPath);
        $path = $splited_path[1] . '/' . $splited_path[2];
        $inputs['image'] = $path;

        Product::create($inputs);
        return redirect()->back()->with('success', "Le produit a été ajouté avec succès!");

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        if($validator->failed()) {
            return redirect()->back()->with('error', "Il y'a eu une erreur lors de la modification! Veuillez réessayer.");
        }

        $inputs = $request->all(['name', 'description', 'price']);
        
        if($file = $request->file('image')) {
            $request->file('image');
            $fullPath = $file->store('public/products');
            $splited_path = explode('/', $fullPath);
            $path = $splited_path[1] . '/' . $splited_path[2];
            $inputs['image'] = $path;
        }

        $product = Product::where('uuid', $id)->first();
        $product->update($inputs);

        return redirect()->back()->with('success', "Le produit a été modifié avec succès!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $product = Product::where('uuid', $id)->first();
        if(!$product) {
            return redirect()->back()->with('error', "Il y'a eu une erreur lors de la suppression! Veuillez réessayer.");
        }

        Product::destroy($product->id);
        return redirect()->back()->with('success', "Le produit a été supprimé avec succès!");
    }
}
