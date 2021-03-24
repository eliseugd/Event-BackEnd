<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use JWTAuth;

class EventController extends Controller
{
    public function __contructor() {

    }
    
    public function index() {
        $events = Event::all();
        return response()->json($events);
    }
        
    public function show(Request $request){
        
        return response()->json($events);
    }

    public function search(Request $request){
        $events = Event::search($request);
        return response()->json($events);
    }

    public function store(){
        try {
            $token = JWTAuth::parseToken();
            $id_user = $token->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub'];
            
            $data = [
                'name' => request('name'),
                'description' => request('description'),
                'date' => request('date'),
                'id_user_creator' => $id_user,
                'id_category' => request('category'),
                'status' => 'A'
            ];
    
            $retorno['data'] = Event::create($data);
            $retorno['error'] = 0;
        } catch (Exception $e) {
            $retorno['error'] = 1;
            $retorno['erro'] = $e->getMessage();
        }

        return response()->json($retorno);
    }
        
    public function edit(Event $event){
        //
    }

    public function update(Event $event, Request $request){
        $event->id = $request->id;
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->data;
        $event->id_category = $request->id_category;
        $event->save();
    }
    
    public function destroy(Event $event){
        $event->delete();
    }
}
