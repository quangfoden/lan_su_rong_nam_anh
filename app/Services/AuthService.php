<?php

namespace App\Services;

use App\Enums\General;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function checkUser(array $requests): array
    {
        $user = $this->userRepo->getUserByEmail($requests['email']);
        if (is_null($user)) {
            return [
                'success' => false,
                "message" => 'Tài khoản không tồn tại.'
            ];
        }
        if ($user->status === 0 || $user->is_lock === 1) {
            return [
                'success' => false,
                "message" => 'Tài khoản của bạn đã bị khoá.'
            ];
        }
        if (!Hash::check($requests['password'], $user->password)) {
            return [
                'success' => false,
                'message' => 'Mật khẩu không đúng.'
            ];
        }
        auth()->login($user);
        return ['success' => true];
    }
}
