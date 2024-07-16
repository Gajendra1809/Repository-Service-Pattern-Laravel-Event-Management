<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService {

    public $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function create($request){

        return $this->userRepository->create($request->all());

    }

    public function login($request){

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return false;
        }
        $user = auth()->user();
        $token = $user->createToken('Personal Access Token')->accessToken;
        return $token;

    }

}
