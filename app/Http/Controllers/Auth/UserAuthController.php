<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserAuthController extends Controller
{
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }



    public function updateAuthInfo(Request $request)
    {
      
        if(auth()->user()->email!=$request->email)
        {
          
            $this->validate($request,[
                    'email' => 'required|string|email|max:255|unique:users',
                ]);
        }
      
        $user=User::find(auth()->user()->id)->update([
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'phone'=>$request->phone,
            'mail'=>$request->email,
        ]);
       
        switch (auth()->user()->is_admin) {
            case '1':
               return redirect()->to('dashboard/index');
                break;
            case '2' : 
                return redirect()->to('dashboard/owner');
                break;
            case '3' : 
               
                return redirect()->to('dashboard/employe');
                break;
            default:
                # code...
                break;
        }
        // return redirect()->back();
    }

    public function updateAuthAccess(Request $request)
    {
    //dd($request->all());
        
        if($request->passwor){
            $this->validate($request,[
            'password' => 'required|string|min:6|confirmed',
            ]);
            $user=User::find(auth()->user()->id)->update([
            'password'=>Hash::make($request->password),
            ]);
            
           
        }
        
      
        
        switch (auth()->user()->is_admin) {
            case '1':
               return redirect()->to('dashboard/index');
                break;
            case '2' : 
                return redirect()->to('dashboard/owner');
                break;
            case '3' : 
                return redirect()->to('dashboard/employe');
                break;
            default:
                # code...
                break;
        }
        return redirect()->back();
    }

}
