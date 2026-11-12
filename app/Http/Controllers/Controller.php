<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // READ - Display all products
    public function index()
    {
        $products = DB::table('products')->get();

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Basic Laravel CRUD</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>

        <body class="bg-light">

        <div class="container mt-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-4">
                        <h3>Product Management</h3>

                        <a href="/products/create" class="btn btn-primary">
                            Add Product
                        </a>
                    </div>';

        if (session('success')) {
            $html .= '
                <div class="alert alert-success">
                    ' . e(session('success')) . '
                </div>';
        }

        $html .= '
                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>';

        foreach ($products as $product) {

            $html .= '
                <tr>
                    <td>' . $product->id . '</td>

                    <td>' . e($product->name) . '</td>

                    <td>' . e($product->description) . '</td>

                    <td>₱' . number_format($product->price, 2) . '</td>

                    <td>

                        <a href="/products/edit/' . $product->id . '"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="/products/delete/' . $product->id . '"
                              method="POST"
                              style="display:inline;">

                            ' . csrf_field() . '

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm(\'Delete this product?\')">

                                Delete

                            </button>

                        </form>

                    </td>
                </tr>';
        }

        $html .= '
                        </tbody>

                    </table>

                    <p>Total Products: ' . $products->count() . '</p>

                </div>
            </div>

        </div>

        </body>
        </html>';

        return response($html);
    }


    // CREATE - Show form
    public function create()
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Add Product</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>

        <body class="bg-light">

        <div class="container mt-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h3>Add Product</h3>

                    <form action="/products/store" method="POST">

                        ' . csrf_field() . '

                        <div class="mb-3">

                            <label>Product Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>Description</label>

                            <textarea name="description"
                                      class="form-control"></textarea>

                        </div>

                        <div class="mb-3">

                            <label>Price</label>

                            <input type="number"
                                   name="price"
                                   step="0.01"
                                   min="0"
                                   class="form-control"
                                   required>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Product
                        </button>

                        <a href="/products" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>
            </div>

        </div>

        </body>
        </html>';

        return response($html);
    }


    // CREATE - Save product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
        ]);

        DB::table('products')->insert([

            'name' => $request->name,

            'description' => $request->description,

            'price' => $request->price,

            'created_at' => now(),

            'updated_at' => now(),

        ]);

        return redirect('/products')
            ->with('success', 'Product successfully added!');
    }


    // UPDATE - Show edit form
    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            abort(404, 'Product not found.');
        }

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Product</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>

        <body class="bg-light">

        <div class="container mt-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h3>Edit Product</h3>

                    <form action="/products/update/' . $product->id . '" method="POST">

                        ' . csrf_field() . '

                        <div class="mb-3">

                            <label>Product Name</label>

                            <input type="text"
                                   name="name"
                                   value="' . e($product->name) . '"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>Description</label>

                            <textarea name="description"
                                      class="form-control">' . e($product->description) . '</textarea>

                        </div>

                        <div class="mb-3">

                            <label>Price</label>

                            <input type="number"
                                   name="price"
                                   value="' . e($product->price) . '"
                                   step="0.01"
                                   min="0"
                                   class="form-control"
                                   required>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update Product
                        </button>

                        <a href="/products" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>
            </div>

        </div>

        </body>
        </html>';

        return response($html);
    }


    // UPDATE - Save changes
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
        ]);

        DB::table('products')
            ->where('id', $id)
            ->update([

                'name' => $request->name,

                'description' => $request->description,

                'price' => $request->price,

                'updated_at' => now(),

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