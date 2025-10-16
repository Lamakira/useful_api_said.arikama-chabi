<?php

namespace App\Http\Middleware;

use App\Models\UserModule;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $moduleId): Response
    {
        $user = Auth::user();
        if(!$user) {
            return response()->json([
                "message" => "Unauthenticated"
            ], 401);
        }
        $isModuleActive = UserModule::where([['user_id', $user->id], ['module_id', $moduleId], ['active', true]])->exists();
        if($isModuleActive) {
            return $next($request);
        }

        return response()->json([
            'error' => 'Module inactive. Please activate this module to use it.'
        ], 403);
    }
}
