<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ProxyResponse
{
    static public function success(mixed $data) : JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
