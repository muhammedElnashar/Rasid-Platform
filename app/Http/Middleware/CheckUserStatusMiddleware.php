<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user) {
            if (!$user->status) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['error' => 'حسابك موقوف، تواصل مع الإدارة لإعادة التفعيل.']);
            }
            $schoolAdmin = User::where('school_id', $user->school_id)->whereRoleId(2)->first();
            if ($schoolAdmin && !$schoolAdmin->status) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['error' => 'المدرسة موقوفة بسبب إيقاف حساب المسؤول.']);
            }
        }


        return $next($request);
    }
}
