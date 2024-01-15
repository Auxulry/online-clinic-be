<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponserTrait
{
    /**
     * @param int $code
     * @param string $message
     * @param $data
     * @return JsonResponse
     */
    public function successResponse(int $code, string $message, $data = []): JsonResponse
    {
        if ($data) {
            return response()->json([
                'code' => $code,
                'status' => Response::$statusTexts[$code],
                'message' => $message,
                'data' => $data
            ], $code);
        } else {
            return response()->json([
                'code' => $code,
                'status' => Response::$statusTexts[$code],
                'message' => $message
            ], $code);
        }
    }

    /**
     * @param int $code
     * @param string $message
     * @param $errors
     * @return JsonResponse
     */
    public function errorResponse(int $code, string $message, $errors = []): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => Response::$statusTexts[$code],
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
