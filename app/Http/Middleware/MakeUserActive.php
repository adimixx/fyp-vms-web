<?php

namespace App\Http\Middleware;

use App\Models\Status;
use Closure;
use Illuminate\Http\Request;

class MakeUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $status = Status::user('active');
        if ($request->user()->status != $status) {
            $request->user()->update([
                'status_id' => $status->id
            ]);
        }
        return $next($request);
    }
}
