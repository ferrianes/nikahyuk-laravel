<?php

namespace App\Helpers;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'status' => 200,
        'data' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null)
    {
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['status']);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['status'] = $code;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['status']);
    }
}
