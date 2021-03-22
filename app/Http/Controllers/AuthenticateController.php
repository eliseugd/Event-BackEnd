<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Repositories\PasswordRepository;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        try {
            $credentials = request(['user', 'password']);
            $usuario = strtoupper($request->user);
            $senha = $request->password;
            $password_rep = new PasswordRepository();

            $user = User::where(DB::raw('upper(username)'), $usuario)->first();
            if (empty($user)) {
                return response()->json(['erro' => 'Usuário ou senha inválido'], 401);
            }

            $verify_password = $password_rep->check($senha, $user->password);
            if(!$verify_password) {
                return response()->json(['erro' => 'Usuário ou senha inválido'], 401);
            }
            
            // return response()->json([$senha,$user->password]);
            JWTAuth::factory()->setTTL(240);  
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'Credenciais inválidas'], 400);
            }

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 1, 'erro' => 'Erro ao tentar criar o token'], 500); // something went wrong whilst attempting to encode the token
        } catch (Exception $e) {
            return response()->json(['error' => 1, 'erro' => 'Houve um erro inesperado'], 500); 
        }

        return response()->json(['error' => 0, 'token' => "$token", 'user' => $user]);
    }

    public function hashPassword()
    {
        $password_rep = new PasswordRepository();
        $result = User::all();

        foreach($result as $key => $user) {
            $senha = $password_rep->hash($user->senha);

            User::where('id', $user->id)->update(['senha' => $senha]);
        }
    }

    public function getAuthenticatedUser()
    {
            try {

                    if (! $user = JWTAuth::parseToken()->authenticate()) {
                            return response()->json(['user_not_found'], 404);
                    }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                    return response()->json(['token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                    return response()->json(['token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    return response()->json(['token_absent'], $e->getStatusCode());

            }

            return response()->json(compact('user'));
    }
}
