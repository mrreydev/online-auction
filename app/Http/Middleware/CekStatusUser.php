<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CekStatusUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::get('id_user')){
            return redirect('/');
        }
        else{
            return redirect()->back();
        }
    }
}
