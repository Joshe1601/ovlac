<?php

namespace App\Http\Controllers;

use App\Helpers\AuthenticationHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends Controller
{
    static $model_tag = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        $api_token = $request->api_token;

        // Auth block
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=index', 'action=login').replace('md=user', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $html = View::make(self::$model_tag . '.index', [
            'users' => $users,
            'api_token' => $api_token,
            'is_admin' => $is_admin,
            'is_logged' => $is_logged
            ])->render();
        return $html;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=create', 'action=login').replace('md=user', 'md=auth').concat('&error=You need admin permissions..');</script>";
            return $redirect;
        }

        $html = View::make(self::$model_tag . '.create', ['form_action' => 'store', 'api_token' => $api_token])->render();
        return $html;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //d($request->is_admin);
            // Auth block
            $api_token = $request->query('api_token');
            $is_logged = AuthenticationHelper::isLogged($api_token);
            $is_admin = AuthenticationHelper::isAdmin($api_token);
            if ($is_logged == null || $is_admin == null) {
                $redirect = "<script>window.location.href = window.location.href.replace('action=store', 'action=login').replace('md=user', 'md=auth').concat('&error=You need admin permissions..');</script>";
                return $redirect;
            }
            $this->validate(
                $request, [
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                ]
            );
            if($request->is_admin == 1){ $input['is_admin'] = 1; }
            elseif(!isset($request->is_admin)){ $input['is_admin'] = 0; }
            $input['password'] = app('hash')->make($request->password);
            $input['email'] = $request->email;
            $input['api_token'] = Str::random(120);
            $user = User::create($input);

            $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=index').replace('action=store', 'action=index');</script>";
            return $redirect;

        } catch (\Exception $e) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=store', 'action=create').concat('&error=Check email and password.');</script>";
            return $redirect;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=edit', 'action=login').replace('md=user', 'md=auth').concat('&error=You need admin permissions..');</script>";
            return $redirect;
        }

        $html = View::make(self::$model_tag . '.edit', [
            'form_action' => 'update',
            'user' => $user,
            'api_token' => $request->api_token
        ])->render();
        return $html;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Auth block
        $api_token = $request->query('api_token');
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=login').replace('md=user', 'md=auth').concat('&error=You need admin permissions..');</script>";
            return $redirect;
        }

        if($request->is_admin == 1){ $user->is_admin = 1; }
        elseif(!isset($request->is_admin)){ $user->is_admin = 0; }

        if ($request->password != '') {
            $user->password = app('hash')->make($request->password);
        }
        $user->email = $request->email;
        $user->save();

        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=index');</script>";
        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=login').replace('md=user', 'md=auth').concat('&error=You need admin permissions..');</script>";
            return $redirect;
        }

        $id = $user->id;
        $user->delete();

        $redirect = "<script>window.location.href = window.location.href.replace('action=destroy', 'action=index').replace('&id=".$id."', '');</script>";
        return $redirect;
    }
}
