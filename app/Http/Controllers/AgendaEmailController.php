<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaEmail;

class AgendaEmailController extends Controller
{
    public function index() {
        $emails = AgendaEmail::all();
        return response()->json($emails);
    }
        
    public function show(AgendaEmail $email){
        $emails = AgendaEmail::find($email);
        return response()->json($emails);
    }

    public function store(){
        $data = [
            'name' => request('name'),
            'description' => request('description'),
            'date' => request('date'),
            'id_user_creator' => request('id_user_creator'),
            'id_category' => request('id_category'),
            'status' => request('status')
        ];

        Product::create($data);
    }
        
    public function edit(Email $email){
        //
    }

    public function update(Email $email, Request $request){
        $email->id = $request->id;
        $email->name = $request->name;
        $email->description = $request->description;
        $email->date = $request->data;
        $email->id_category = $request->id_category;
        $email->save();
    }
    
    public function destroy(Email $email){
        $email->delete();
    }
}
