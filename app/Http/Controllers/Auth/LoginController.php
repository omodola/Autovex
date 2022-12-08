<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    private const LOGOUT_MESSAGE = 'Log out successful.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request): JsonResponse|Response
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            if($user){
                $user->generateToken();
            }

            if($request->wantsJson()){
                return response()->json([
                    'data' => $user->toArray(),
                ]);
            }
            return redirect($this->redirectTo);
        }

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
            $user->tokens()->delete();
        }

        Auth::logout();
        if($request->wantsJson()){
            return response()->json(['data' => self::LOGOUT_MESSAGE]);
        }

        return redirect($this->redirectTo)->with('status', self::LOGOUT_MESSAGE);
    }
}
