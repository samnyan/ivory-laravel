<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 * APIs for authentication
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Login
     *
     * Get a JWT via given credentials.
     * @bodyParam email string required The email of the user. Example: me@example.comciw
     * @bodyParam password string required The password of the user. Example: 12345678
     * @response {
     *  "access_token": "",
     *  "token_type": "bearer",
     *  "expires_in": 3600
     * }
     * @response 401 {
     *  "message": "登录验证失败"
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $validate = request()->validate([
            'email' => 'required|email'
        ]);
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => '登录验证失败'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register
     *
     * Register user from api request
     * @bodyParam username string required The username of the user. Example: demo
     * @bodyParam password string required The password of the user. Example: 12345678
     * @bodyParam email string required The email of the user. Example: me@example.com
     * @bodyParam sex integer required The sex of the user. Example: [0, 1, 2]
     * @bodyParam age integer required The age of the user. Example: 24
     * @response {
     *  "message": "注册成功"
     * }
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|min:3|max:16|unique:users,username',
            'password' => 'required|min:8|max:20',
            'email' => 'required|email|unique:users,email',
            'sex' => 'required|integer|between:0,2',
            'age' => 'required|integer|between:0,150'
        ]);

        $user = new \App\User;
        $user->username = $request->get('username');
        $user->pwd = Hash::make($request->get('password'));
        $user->email = $request->get('email');
        $user->type = 0;
        $user->sex = $request->get('sex');
        $user->age = $request->get('age');
        $user->save();
        return response()->json(['message' => '注册成功']);
    }

    /**
     * Me
     * @authenticatied
     * Get the authenticated User.
     *
     * @response {
     * "id": 2,
     * "created_at": null,
     * "updated_at": null,
     * "type": 0,
     * "username": "example",
     * "sex": 0,
     * "age": 0,
     * "head_portrait": null,
     * "clinic": null,
     * "mobile": null,
     * "email": "me@example.com",
     * "fixphonenumber": null,
     * "certificat": null,
     * "certificat_checked": null,
     * "wechat": null,
     * "intro": null,
     * "school": null,
     * "major": null
     * }
     * @apiResourceModel \App\User
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Logout
     * @authenticated
     * Log the user out (Invalidate the token).
     * @response {
     *  "message": "登出成功"
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => '登出成功']);
    }

    /**
     * Refresh token
     * @authenticated
     * Refresh a token.
     * @response {
     *  "access_token": "",
     *  "token_type": "bearer",
     *  "expires_in": 3600
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
