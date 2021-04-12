<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\Object\UserObject;

class AuthController extends Controller
{

  /**
   * Property for make a response.
   *
   * @var  App\Helpers\Response  $response
   */
    protected $response;
    protected $userRepository;

    public function __construct(Response $response, UserRepository $userRepository)
    {
        $this->response         = $response;
        $this->userRepository   = $userRepository;
    }

    /**
     * Validate the description field.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function validateData($request)
    {
        return Validator::make($request, [
            'rut'               => 'required|max:12|string',
            'name'              => 'required|max:200|string',
            'phone'             => 'required|max:12|string',
            'email'             => 'required|max:255|email|unique:users',
            'lastname'          => 'required',
            'mother_lastname'   => 'required'
        ]);
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $validate = $this->validateData(request()->all());

            if ($validate->fails()) {
                return $this->response->customMessageResponse(($validate->errors()), 406);
            }

            $user = $this->userRepository->store($request);

            return $this->response->created(new UserObject($user));
        } catch (\Exception $ex) {
            return $this->response->internalServerError($ex);
        }
    }

    public function createAdmin(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $user = $this->userRepository->storeAdmin(request());

            return $this->response->created(new UserObject($user));
        } catch (\Exception $ex) {
            return $this->response->internalServerError($ex);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'rut' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['rut', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
      'message' => 'Successfully logged out'
    ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = $request->user();

        $searchUser = User::find($user->id);

        return response()->json([
      'user' => $searchUser], 200);
    }
}
