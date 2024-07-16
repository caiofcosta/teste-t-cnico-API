<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Swagger API Desafio Tecnico",
 *      @OA\Contact(
 *          email="caiocostasp@gmail.com"
 *      ),
 * )
 * 
 * @OA\PathItem(
 *      path="/api"
 * )
 */

class BaseController extends Controller
{
    public function sendResponse($result, $message, $code_status = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, $code_status);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
