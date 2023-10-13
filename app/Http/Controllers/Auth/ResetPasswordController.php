<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Model\MailCheckModel;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function CheckToken(Request $request)
    {
        $mail=$request->get('email');
//        $mailObject=new MailCheckModel();
////        $flag=$mailObject->mailCheck($mail);

        $User=User::whereEmail($mail)->first();
        if ($User!=null)
        {
           return view('auth.passwords.reset');
        }
        else
        {
//            return redirect()->route('Auth/password/reset')->with('error', 'State saved correctly!!!');
            return view('auth.passwords.email')->with('error',"Email is not valid");
        }
    }

    public function UpdatePassword(Request $request)
    {
       $password=$request->input('password');
       $password_confirmation=$request->input('password_confirmation');
       $email=$request->input('email');

        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required:8'
        ]);


        if (!strcmp($password,$password_confirmation))
       {
           $obj=new MailCheckModel();
           $flag=$obj->updatePassword($request);
           return view('auth.login');
       }
       else
       {
           return view('auth.passwords.reset')->with('password',"Password are not same,try again");
       }
    }
}
