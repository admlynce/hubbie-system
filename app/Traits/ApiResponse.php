<?php

namespace App\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
       protected function successResponse($data)
    {
        return response()->json([$data], 200);
    }

    public function successResponse2($data, $code = Response::HTTP_OK)
    {

        return response($data, $code)->header('Content-Type', 'application/json');
    }

    /**
     * Build error responses
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Build error responses
     *
     * @param string $message
     * @param int $code
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function errorMessage($message, $code)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }


}
