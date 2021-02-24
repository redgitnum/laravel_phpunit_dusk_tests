<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'count' => 'required|numeric|min:1|max:100',
            'location' => 'required|string|min:3',
        ]);

        if(Product::where('name', $request->name)->first()){
            return back()->with('duplicate', 'Product with that name already exists');
        }

        try{
            Product::create([
                'name' => $request->name,
                'count' => $request->count,
                'location' => $request->location
            ]);
        } catch (QueryException $e) {
            return back()->withErrors($e, 'Something went wrong');
        }
        return back()->with('success', 'Product saved successfully!');
    }

    public function delete(Request $request)
    {
        Product::find($request->id)->first()->delete();
        return back()->with('delete', 'Product deleted successfully');
    }
}
