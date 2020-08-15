<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function SessionUser(Request $request)
    {

        if (Auth::user() !== null) {

            $user = Auth::user();
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
            $user->update(['api_token' => null]);

            Auth::logout();
            return redirect()->route('login');
        } else {
            return redirect('/');
        }
    }
    public function register(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        );

        $input = $request->all();

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];

            return response()->json($response, 403);
        }

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['access_token'] = $user->createToken('Laravel Passport Create Access Token')->accessToken;
        $success['name'] = $user->name;

        $response = array(
            'success' => true,
            'data' => $success,
            'message' => 'User register Successfully',
        );

        return response()->json($response, 200);
    }

    public function login()
    {
        // return response()->json($request->all());

        // $http = new Client();
        // try {
        //     $response = $http->post(config('services.passport.login_endpoint'),[
        //         'form_params'=>[
        //             'grant_type'=>'password',
        //             'client_id'=>config('services.passport.client_id'),
        //             'client_secret'=>config('services.passport.client_secret'),
        //             'username'=>$request->email,
        //             'password'=>$request->password,
        //         ]
        //     ]);

        //     return $response->getBody();
        // } catch (BadResponseException $e) {
        //     if($e->getCode() === 400)
        //     {
        //         return response()->json('Invalid Request. Please Enter a username or a password.',$e->getCode());
        //     }
        //     else if($e->getCode() === 401){
        //         return response()->json('Your credentials are incorrect. Please try again',$e->getCode());
        //     }

        //     return response()->json('Something is wrong with the server',$e->getCode());

        // }


        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $success['access_token'] = $user->createToken('Laravel Passport Create Access Token')->accessToken;
            $success['user'] = $user;

            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout()
    {
        // return redirect()->route('logout');
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        // return response()->json('Logged out successfully',200);
        // $token = $request->user()->token();
        // $token->revoke();

        // $response = 'You have been successfully logged out!';
        // return response($response,200);
    }

    public function fetchUsers(Request $request)
    {
        $keywords = $request->query('keywords');

        $users = User::with('roles', 'permissions')->where('first_name', 'like', '%' . $keywords . "%")->orWhere('last_name', 'like', '%' . $keywords . "%")->get();

        return response()->json(compact('users'));
    }
    public function getUsers(Request $request)
    {
        $keywords = $request->query('keywords');

        $users = User::with('roles', 'permissions')->latest()->where('first_name', 'like', '%' . $keywords . "%")->orWhere('last_name', 'like', '%' . $keywords . "%")->orWhere('given_name', 'like', '%' . $keywords . "%")->paginate();

        return response()->json(compact('users'));
    }
    public function getUser($user)
    {
        $userId = $user;
        $users = new User();
        if ($users->where('id', $userId)->exists()) {
            $user = $users->with('roles', 'permissions')->find($userId);

            return response()->json(compact('user'));
        } else {
            return response()->json(['message' => 'user not found']);
        }
    }
}
