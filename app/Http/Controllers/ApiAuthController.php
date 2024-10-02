<?php

namespace App\Http\Controllers;

use App\Services\ApiTokenService;
use App\Services\ApiUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    private ApiUserService $apiUserService;
    private ApiTokenService $apiTokenService;

    public function __construct()
    {
        $this->apiUserService = new ApiUserService();
        $this->apiTokenService = new ApiTokenService();
    }

    public function registerUser(Request $request): JsonResponse
    {
        return $this->apiUserService->registerUser($request);
    }

    public function createToken(Request $request): JsonResponse
    {
        return $this->apiTokenService->createToken($request);
    }
}
