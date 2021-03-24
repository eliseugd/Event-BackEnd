<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\UserEvent;
use App\Models\UsersEventView;
use App\Mail\SendMail;
use JWTAuth;

class EventUserController extends Controller
{
    public function index() {
        $events = UsersEventView::all();
        return response()->json($events);
    }
        
    public function show(Request $request){
        $events = UsersEventView::search($request);
        return response()->json($events);
    }

    public function store(Request $request){
        try {
            foreach($request->usersInvite as $key => $value) {
                $data = [
                    'id_user' => $value['id'],
                    'id_event' => $request->id_event,
                    'participation_situation' => 'P',
                ];

                Mail::to($value['email'])->send(new SendMail());
        
                UserEvent::create($data);
            }

            $retorno['error'] = 0;
        } catch (Exception $e) {
            $retorno['error'] = 0;
            $retorno['message'] = $e->get_message;
        }

        return response()->json($retorno);
    }

    public function eventsAvailable() {
        $id_user = '';
        if(JWTAuth::getToken()) {
            $token = JWTAuth::parseToken();
            $id_user = $token->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub'];
        }

        $events = Event::available($id_user);
        return response()->json($events);
    }
        
    public function edit(UserEvent $event){
        //
    }

    public function update(UserEvent $event, Request $request){
        $event->id = $request->id;
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->data;
        $event->id_category = $request->id_category;
        $event->save();
    }

    public function aprovarParticipation(Request $request){
        UserEvent::find($request->id_user_event)->update(['participation_situation' => 'A']);
    }

    public function cancelParticipation(Request $request){
        $token = JWTAuth::parseToken();
        $id_user = $token->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub'];

        $eventCancel = Event::find($request->id_event);
        
        if($eventCancel['id_user_creator'] == $id_user) {
            Event::find($request->id_event)->update(['status' => 'C']);
            UserEvent::where('id_event', $request->id_event)->update(['participation_situation' => 'C']);
        } else {
            UserEvent::where('id_event', $request->id_event)
            ->where('id_user', $id_user)
            ->update(['participation_situation' => 'C']);
        }
    }
    
    public function destroy(UserEvent $event){
        $event->delete();
    }
}
