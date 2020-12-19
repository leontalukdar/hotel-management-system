<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Repository\UserRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    use RespondsWithHttpStatus;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function registerUser(UserRegisterRequest $request)
    {
        try {
            $res = $this->userRepository->register($request);
            return $res;
        } catch (\Exception $e) {
            Log::error("Register error", [
                'error' => $e->getMessage()
            ]);
            return $this->apiResponse($e->getMessage(), null, Response::HTTP_INTERNAL_SERVER_ERROR, false);
        }
    }
}
