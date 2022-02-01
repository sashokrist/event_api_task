<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Login user
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"register"},
     *     operationId="createUser",
     *
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="admin@admin.com",
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password - 11111111",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="11111111",
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     *
     * )
     */
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }
}
