<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // READ - Display all products
    public function index()
    {
        $products = DB::table('products')->get();

        return view('products.index', compact('products'));
    }

    // CREATE - Save product
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
        ]);

        DB::table('products')->insert([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect('/products')
            ->with('success', 'Product successfully added!');
    }

    // UPDATE - Save changes
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
        ]);

        DB::table('products')
            ->where('id', $id)
            ->update([
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
                'updated_at'  => now(),
            ]);

        return redirect('/products')
            ->with('success', 'Product successfully updated!');
    }

    // DELETE - Remove product
    public function destroy($id)
    {
        DB::table('products')
            ->where('id', $id)
            ->delete();

        return redirect('/products')
            ->with('success', 'Product successfully deleted!');
    }
}