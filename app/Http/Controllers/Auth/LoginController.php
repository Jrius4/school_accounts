<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admins')->except('logout');
        $this->middleware('guest:students')->except('logout');
    }

    public function showLoginForm()
    {
        $loggedOut = true;
        return view('auth.login',compact('loggedOut'));
    }
    public function showAdminLoginForm()
    {
        $loggedOut = true;
        return view('auth.login', ['url' => 'admin','loggedOut'=>$loggedOut]);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'password' => 'required|min:6'
        ]);


        if (Auth::guard('admins')->attempt(['name' => $request->name, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('name', 'remember'));
    }

    public function showStudentLoginForm()
    {
        $loggedOut = true;
        return view('auth.login', ['url' => 'student','loggedOut'=>$loggedOut]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:6'
        ]);



        if (Auth::guard()->attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {

            $id = Auth::user()->id;
            $user = User::where('id',$id)->first();
            $user->tokens->each(function($token,$key){
                $token->delete();
            });
            $user->update(['api_token'=>null]);
            $access_token = $user->createToken('Laravel Passport Create Access Token')->accessToken;
            $user->update(['api_token'=>$access_token]);
            $user = $user->name;

            return redirect()->intended('/dashboard')->with(['success'=>'Logging successfully','user'=>$user,'access_token'=>$access_token]);

        }

        else{
            return redirect('/')->with(['message'=>'username and credients']);
        }
        return back()->withInput($request->only('name', 'remember'));
    }

    public function studentLogin(Request $request)
    {
        $this->validate($request, [
            'roll_number'   => 'required',
            'password' => 'required|min:6'
        ]);


        if (Auth::guard('students')->attempt(['roll_number' => $request->roll_number, 'password' => $request->password], $request->get('remember'))) {

            $id = Auth::guard('students')->user()->id;
            $user = Student::where('id',$id)->first();
            $user->tokens->each(function($token,$key){
                $token->delete();
            });
            $user->update(['api_token'=>null]);
            $access_token = $user->createToken('Laravel Passport Create Access Token')->accessToken;
            $user->update(['api_token'=>$access_token]);
            $user = $user->name;

            return redirect()->intended('/student')->with(['success'=>'Logging successfully','user'=>$user,'access_token'=>$access_token]);
        }
        else{
            return redirect('/')->with(['message'=>'wrong roll number']);
        }
        return back()->withInput($request->only('name', 'remember'));
    }




    public function username()
    {
        return 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        $user->last_seen_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $student = AUth::guard('students')->user();

        if($user!==null){

            $user->tokens->each(function($token,$key){
                $token->delete();
            });
            $user->update(['api_token'=>null]);
        }
        else if ($student !==null){
            $student->tokens->each(function($token,$key){
                $token->delete();
            });
            $student->update(['api_token'=>null]);
        }



        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }


}
