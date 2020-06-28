<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
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
    // If user is not logged in...
    if (!Auth::check()) {
      return $next($request);
    }

    $user = Auth::guard()->user();
    $student = Auth::guard('students')->user();

    $now = Carbon::now();

    $last_seen = Carbon::parse($user->last_seen_at);
    $student_last_seen = Carbon::parse($student->last_seen_at);
    $absence = $now->diffInMinutes($last_seen);
    $absence_student = $now->diffInMinutes($student_last_seen);

    // If user has been inactivity longer than the allowed inactivity period
    if ($absence > config('session.lifetime')) {
      Auth::guard()->logout();

      $request->session()->invalidate();

      return $next($request);
    }

    if($absence_student>config('session.lifetime')){
        Auth::guard('students')->logout();
        $request->session()->invalidate();
        return $next($request);
    }

    $user->last_seen_at = $now->format('Y-m-d H:i:s');
    $user->save();

    $student->last_seen_at = $now->format('Y-m-d H:i:s');
    $student->save();


    return $next($request);
  }
}
