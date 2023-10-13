<?php

namespace Illuminate\Foundation\Auth;

use App\Model\TraineesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Classes\Database;
use Illuminate\Support\Facades\Log;
use GuzzleHttException\GuzzleException;
use GuzzleHttp\Client as GZClient;
use App\Http\Controllers\SmsController;
use Illuminate\Validation\Rules\Exists;
use mysql_xdevapPHPUnit\Exception;
use Session;
use Webklex\IMAP\Client;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $orignalMail = $request['email'];
        $password = $request['password'];
        $userCheck = \App\User::where('email', $orignalMail)->exists();
        $traineeExist = TraineesModel::where('email', $orignalMail)->exists();
        $traineeCheck = TraineesModel::where('email', $orignalMail)->first();
        $authhost="{mail.ntdc.com.pk:993/imap/ssl/novalidate-cert}";
        $traineeId=DB::table('trainees')
            ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
            ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
            ->where('add_courses.status', '=', '1')
            ->where('trainees.email', '=', $orignalMail)
            ->value('trainees.tid');
        $email=explode('@',$orignalMail);

        if ($password==$email[0]){
                $getuserinfo=array(
                    'userid'=>$traineeId,
                    'username'=>$traineeCheck['name'],
                    'useremail'=>$traineeCheck['email'],
                    'external'=>'yes',
                    'loggedin'=>true,
                );
                $request->session()->put($getuserinfo);
                return view('home')->with('not_trainee','no')->with('outsider','yes');
        }
        if (empty($userCheck) && empty($traineeExist))
        {
            $email=explode('@',$orignalMail);
            $isConnected = false;
            try {
                $mbox=imap_open($authhost, $email[0], $password);
                $isConnected = true;
                imap_close($mbox);
            }
            catch (\Exception $e)
            {
                return redirect('/logout');
            }
            if ($isConnected===true)
            {
                $userData=DB::connection('mysql2')->table('personal')
                    ->select('personal.MyId','personal.Name','personal.DepartmentId', 'personal.Grade')
                    ->where('personal.Email','=',$orignalMail)
                    ->get();
                foreach($userData as $user)
                {
                    $getuserinfo=array(
                        'userid'=>$user->MyId,
                        'username'=>$user->Name,
                        'useremail'=>$email,
                        'loggedin'=>true,
                    );
                }
                $request->session()->put($getuserinfo);
                return view('home')->with('not_trainee','yes');
            }

        }
        elseif (empty($userCheck)&&!empty($traineeExist))
        {

//            Log::info("first if");
            $email=explode('@',$orignalMail);

            $isConnected = false;
            try {
                $mbox=imap_open($authhost, $email[0], $password);
                $isConnected = true;
                imap_close($mbox);
            }
            catch (\Exception $e)
            {
                return redirect('/logout');
            }

            if ($isConnected)
            {
                $userData=DB::connection('mysql2')->table('personal')
                    ->select('personal.MyId','personal.Name','personal.DepartmentId', 'personal.Grade')
                    ->where('personal.Email','=',$orignalMail)
                    ->get();
                foreach($userData as $user)
                {
                    $getuserinfo=array(
                        'userid'=>$user->MyId,
                        'username'=>$user->Name,
                        'useremail'=>$email,
                        'loggedin'=>true,
                    );
                }

                $request->session()->put($getuserinfo);
                return view('home')->with('not_trainee','no')->with('outsider','no');
            }
            else{
                return view('home')->with('not_trainee','no');
            }
        }
        if (!empty($traineeExist) && empty($userCheck)&&!empty($isConnected)) {
//            Log::info("second if");
            $userData=DB::connection('mysql2')->table('personal')
                ->select('personal.MyId','personal.Name','personal.DepartmentId', 'personal.Grade')
                ->where('personal.Email','=',$orignalMail)
                ->get();
            foreach($userData as $user)
            {
                $getuserinfo=array(
                    'userid'=>$user->MyId,
                    'username'=>$user->Name,
                    'useremail'=>$email,
                    'loggedin'=>true,
                );
            }

            $request->session()->put($getuserinfo);
            return view('home')->with('not_trainee','no');
        } elseif(empty($traineeExist) && !empty($userCheck)){
            $this->validateLogin($request);


            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
        else
        {
            return view('auth.login')->with('error','Invalid User..Kindly User Proper Credentials');
        }
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
//        throw ValidationException::withMessages([
////            $this->username() => [trans('auth.failed')],
////        ]);
        return view('auth.login')->with('error','Invalid User..Kindly Use Proper Credentials');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
