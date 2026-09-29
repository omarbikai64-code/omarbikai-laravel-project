<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Extract token from X-API-TOKEN or Authorization Bearer header
        $token = $request->header('X-API-TOKEN');

        if (!$token && $request->hasHeader('Authorization')) {
            $header = $request->header('Authorization');
            if (str_starts_with($header, 'Bearer ')) {
                $token = substr($header, 7);
            }
        }

        // 2. Validate token presence
        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: API Token is missing.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // 3. Verify token against database
        $validKey = ApiKey::where('key', $token)
            ->where('is_active', true)
            ->exists();

        if (!$validKey) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: Invalid or revoked API Token.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}