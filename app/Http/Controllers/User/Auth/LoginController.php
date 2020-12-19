<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Repository\UserRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use RespondsWithHttpStatus;

    private $userRepository;

    /**
     * Undocumented function
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        Auth::shouldUse('api');
    }

    /**
     * Undocumented function
     *
     * @param UserLoginRequest $request
     * @return void
     */
    public function userLogin(UserLoginRequest $request)
    {
        return $this->userRepository->login($request);
    }
}
