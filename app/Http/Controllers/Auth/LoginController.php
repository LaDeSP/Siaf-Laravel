<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = 'home';



    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->intended('login');
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

    public function login(Request $request)
    {
        $data = $request->all();

        $validacao = Validator::make($data, [
            'cpf' => 'required|cpf',
            'password' => 'required|min:6',
            ]);

        if($validacao->fails())
        {
            return back()->with('errors', $validacao->errors());
        }

        $remember = $request->input('remember_me');
        $data['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);
        if (Auth::attempt(['cpf' => $data['cpf'], 'password' => $data['password']], $remember))
        {
            return redirect()->intended('home');
        }
        else
        {
            return back()->with('error', 'Credenciais informadas não foram encontradas!');
        }

    }
}
