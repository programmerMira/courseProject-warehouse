<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;


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
    protected $redirectTo = 'main';

    public function authLogin(Request $request)
    {
            $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
            ]);


            $credentials['login'] = $request->get('login');
            $credentials['password'] = $request->get('password');

            if (!\Auth::attempt($credentials))
                 return response()->json([
                'message' => 'Ошибка авторизации! Неправильно введен телефон или код из СМС!'
            ]);

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            \Session::put('token', '$tokenResult->accessToken');
            return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
            $tokenResult->token->expires_at
            )->toDateTimeString()
            ]);
        }
        public function authenticate(Request $request)
        {
            if (\Auth::attempt(['login' => $request->login, 'password' => $request->password], $request->remember)) {
                $user = \Auth::user(); 
                $tokenResult = $user->createToken('Personal Access Token'); 
                $token = $tokenResult->token; 
                $token->save(); 
                return redirect('/details')->with('token', $tokenResult->accessToken);
            }
            else{
                return $message = 'Ошибка авторизации! Неправильно введен логин или пароль!';
                return view('auth.login', compact('message'));
            }
        }

        public function logout(Request $request)
        {
            if (\Auth::check()) {
                \Auth::user()->AauthAcessToken()->delete();
                \Auth::logout();
                return redirect()->intended('/');
             }
            return response()->json(['message' => 'Пользователя не существует!']);
        
        }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'login';
    }
}
