<?php

namespace App\Utils;

class Utils
{
    public static function successResponse($data = [], $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }

    public static function errorResponse($message = 'Error', $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}
