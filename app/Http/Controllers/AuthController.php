<?php

namespace App\Http\Controllers;

use App\Helpers\AuthenticationHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    static $model_tag = 'auth';

    public function create()
    {
        return View('auth.register');
    }

    public function store(Request $request)
    {
        dd('store en AuthController, hay que borrarlo');
        try {
            unset($_GET['registration_error']);
            $this->validate(
                $request, [
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                ]
            );
            $input['password'] = app('hash')->make($request->password);
            $input['email'] = $request->email;
            $input['api_token'] = Str::random(120);
            $user = User::create($input);
            if (isset($_GET['registration_error'])) unset($_GET['registration_error']);
            return redirect()->route('auth.dashboard', ['api_token' => $user->api_token]);

        } catch (\Exception $e) {
            return redirect()->route('auth.create', ['registration_error' => 'Please, check email and password fields.']);
        }
    }


    public function dashboard()
    {
        return View('auth.dashboard');
    }
    public function login()
    {
        $html = View::make(self::$model_tag . '.login', ['form_action' => 'verify_user'])->render();
        return $html;
    }

    public function verify_user(Request $request)
    {
        try {
            $this->validate(
                $request, [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );
            $user = User::where('email', $request->email)->first();
            if (is_null($user)) {
                $redirect = "<script>window.location.href = window.location.href.replace('action=verify_user', 'action=login').concat('&error=Please, check email and try again.');</script>";
                return $redirect;
            }
            if (!is_null($user) && app('hash')->check($request->password, $user->password)) {
                // Authentication
                $user->api_token = Str::random(120);
                $user->save();

                if(AuthenticationHelper::isAdmin($user->api_token)) {
                    $redirect = "<script>window.location.href = window.location.href.replace('action=verify_user', 'action=index').replace('md=auth', 'md=user').concat('&api_token=$user->api_token');</script>";
                } else {
                    $redirect = "<script>window.location.href = window.location.href.replace('action=verify_user', 'action=index').replace('md=auth', 'md=product').concat('&api_token=$user->api_token');</script>";
                }


                return $redirect;
            } else {
                $redirect = "<script>window.location.href = window.location.href.replace('action=verify_user', 'action=login').concat('&error=Please, check password and try again..');</script>";
                return $redirect;
            }

        } catch (\Exception $e) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=verify_user', 'action=login').concat('&error=Check email and password.');</script>";
            return $redirect;
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->api_token = null;
            $user->save();
            auth()->guard('web')->logout();

            //return redirect()->route('auth.login');
            // href="{{ controller_path() }}{{ controller_sep() }}md=user&action=index"
            $redirect = "<script>window.location.href = window.location.href.replace('action=index', 'action=login').replace('md=product', 'md=auth').replace('md=user', 'md=auth');</script>";
            dd('vamos a redirect', window.location.href);
            //return $redirect;
        } catch (\Exception $e) {
            //dd('Algo falla en el logout');
            //return redirect()->route('auth.login');
            $redirect = "<script>window.location.href = window.location.href.replace('action=logout', 'action=login');</script>";
            return $redirect;
        }
    }

    public function forgotPassword()
    {
        return View('auth.forgotpassword');
    }

    public function sendEmailLink(Request $request){

       // dd('forgot password', $request);
        $this->validate(
            $request, [
                'email' => 'required|email',
            ]
        );

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return redirect()->route('auth.forgot_password', ['resetpassword_error' => 'Email not found']);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Email sent'], 200);
    }

    public function resetPassword(Request $request)
    {
        $this->validate(
            $request, [
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|min:6',
            ]
        );

        $user = User::where('email', $request->email)
            ->where('api_token', $request->token)
            ->where('reset_token_created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 hour')))
            ->first();
        if(!$user){
            return response()->json(['error' => 'Invalid token or email'], 401);
        }

        $user->password = app('hash')->make($request->password);
        $user->api_token = Str::random(120);
        $user->reset_token = null;
        $user->save();

        return redirect()->route('user.dashboard', ['api_token' => $user->api_token]);
    }
}
