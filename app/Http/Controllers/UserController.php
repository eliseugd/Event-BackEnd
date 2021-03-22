<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\PasswordRepository;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return response()->json($users);
    }
        
    public function show(User $user){
        $users = User::fill($user);
        return response()->json($users);
    }

    public function store(){
        try {
            $password_rep = new PasswordRepository();

            $password = $password_rep->hash(request('password'));

            $data = [
                'username' => request('username'),
                'name' => request('name'),
                'email' => request('email'),
                'phone' => request('phone'),
                'birth_date' => request('birth_date'),
                'password' => $password,
            ];
    
            $retorno['data'] = User::create($data);
            $retorno['error'] = 0;
        } catch (Exception $e) {
            $retorno['error'] = 1;
            $retorno['message'] = $e->getMessage();
        }

        return response()->json($retorno);
    }
        
    public function edit(User $user){
        //
    }

    public function update(User $user, Request $request){
        $user->id = $request->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bith_date = $request->bith_date;

        $user->save();
    }
    
    public function destroy(User $user){
        $user->delete();
    }
}
