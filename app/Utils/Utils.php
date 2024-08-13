<?php

namespace App\Utils;

use Auth;

class Utils
{
    
    public static function  sendResponse($data, $message)
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public static function errorResponse($error, $errorMessages = [], $statusCode = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $statusCode);
    }

    public static function errorResponses($error, $errorMessages = [], $statusCode = 404)
    {
        $response = [
            'success' => false,
            'error' => $error,
            'message' => $errorMessages,
        ];

        // if (!empty($errorMessages)) {
        //     $response['data'] = $errorMessages;
        // }
        return response()->json($response, $statusCode);
    }
}
