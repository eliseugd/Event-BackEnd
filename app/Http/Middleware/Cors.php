<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->isMethod('OPTIONS')) {
            $response = new Response("", 200);

            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Allow-Methods', 'GET,HEAD,PUT,POST,DELETE,PATCH,OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Origin');
        }
        else {
            $response = $next($request);

            $response->headers->set('Access-Control-Allow-Origin' , '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE, PATCH');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Origin');
            $response->headers->set('Access-Control-Expose-Headers', 'Authorization');
            $response->headers->set('X-CSRF-TOKEN', csrf_token());
        }
        
        return $response;
    }
}