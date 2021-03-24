<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryEvent;

class CategoryEventController extends Controller
{
    public function index() {
        $categories = CategoryEvent::all();
        return response()->json($categories);
    }
        
    public function show(CategoryEvent $category){
        $categories = CategoryEvent::find($category);
        return response()->json($categories);
    }

    public function store(){
        $data = [
            'description' => request('description'),
        ];

        Product::create($data);
    }
        
    public function edit(CategoryEvent $category){
        //
    }

    public function update(CategoryEvent $category, Request $request){
        $category->id = $request->id;
        $category->description = $request->description;
        $category->save();
    }
    
    public function destroy(CategoryEvent $category){
        $category->delete();
    }
}
