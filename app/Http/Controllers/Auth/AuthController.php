<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
      
        $data=$request->all();
       
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(auth()->attempt(array('email' => $data['email'], 'password' => $data['password'])))
        {
            if (auth()->user()->is_admin == 1) {
              //  dd('you are a super Admin');
                return redirect()->route('index');
            }elseif(auth()->user()->is_admin == 2){
            // dd('you are an owner');
                return redirect()->route('owner.dashboard');
            }elseif(auth()->user()->is_admin==3){
                
                return redirect('dashboard/employe');
                echo 1;exit;
            }
        }else{
     
            return view('authentication.login')->with('errors_auth',trans('Mot de passe ou E-mail est incorrecte'));
        }
    }

    
}
