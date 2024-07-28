<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $msg = [];
            foreach ($validator->errors()->toArray() as $val) {
                foreach ($val as $error) {
                    $msg[] = $error;
                }
            }
            return response()->json([
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => $msg,
                'authenticated' => false,
            ]);
        }

        $checkData = $this->authService->checkUser($request->all());
        if (!$checkData['success']) {
            return response()->json([
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => [$checkData['message']],
                'authenticated' => false,
            ]);
        } else {
            return response()->json([
                'response_index' => true,
                'response_type' => 'success',
                'response_data' => ['You Have Logged In Successfully'],
                'authenticated' => true,
            ]);
        }
    }
}
