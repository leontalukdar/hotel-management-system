<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\Transformation\UserTransformation;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;
use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use JWTAuthException;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    use RespondsWithHttpStatus;

    private $model, $userTransformation;

    public function __construct(User $model, UserTransformation $userTransformation)
    {
        $this->model = $model;
        $this->userTransformation = $userTransformation;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return void
     */
    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->apiResponse(ResponseMessage::INVALID_CREDENTIALS, Null, Response::HTTP_BAD_REQUEST, false);
            }
        } catch (JWTAuthException $e) {
            Log::error("Authentication error", [
                'error' => ResponseMessage::AUTHENTICATION_ERROR
            ]);
            return $this->apiResponse(ResponseMessage::AUTHENTICATION_ERROR, Null, Response::HTTP_BAD_REQUEST, false);
        }
        $map = $this->userTransformation->toArray(Auth::user());
        $data = ['access_token' => $token, 'user_info' => $map];
        return $this->apiResponse(ResponseMessage::LOGIN_SUCCESS, $data);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return void
     */
    public function register($request)
    {
        $user = $this->model->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'registered_at' => Carbon::now()
        ]);
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $data = ['access_token' => $token, 'user_info' => $user];
        return $this->apiResponse(ResponseMessage::REGISTRATION_SUCCESS, $data);
    }
}
