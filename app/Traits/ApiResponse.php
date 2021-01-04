<?php
/**
 * Created by Lee.
 * DateTime: 2018/9/5 20:32
 */
namespace App\Traits;

trait ApiResponse{

    /**
     * @param $message
     * @param $status
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = [], $message = 'request success' , $status = 0)
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
            'code'    => $status,
        ]);
    }

    public function message($message = 'request success', $status = 0)
    {
        return response()->json([
            'message' => $message,
            'code'    => $status,
        ]);
    }

    public function apiResponse($data = [], $message = 'Request Success ！', $code = 0)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ]);
    }


    /**
     * @param $message
     * @param $status
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function fail($message, $status = 400, $data = [])
    {
        return response()->json([
            'message' => $message,
            'code'    => $status,
            'data' => $data
        ]);
    }
}
