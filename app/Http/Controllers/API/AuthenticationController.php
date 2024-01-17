<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Http\Request;

class AuthenticationController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw new BadRequestHttpException(json_encode([
                'message' => 'Invalid email and password',
            ]));
        }

        if (!Hash::check($request->password, $user->password)) {
            throw new BadRequestHttpException(json_encode([
                'message' => 'Invalid email and password',
            ]));
        }

        return $this->successResponse(Response::HTTP_OK, 'Login Successfully',['accessToken' => $user->createToken('PAT')->accessToken]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'birthdate' => Carbon::parse($request->birthdate)->format('Y-m-d'),
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        return $this->successResponse(Response::HTTP_CREATED, 'Register Success', ['accessToken' => $user->createToken('PAT')->accessToken]);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->successResponse(Response::HTTP_OK, 'Get Profile Success', $request->user());
    }
}
