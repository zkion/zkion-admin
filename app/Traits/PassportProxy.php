<?php
namespace App\Traits;

use GuzzleHttp\Client;

trait PassportProxy {

    private $http;

    public function __construct()
    {
        $this->http = new Client();
    }


    public function passport(array $data = [])
    {
        $data = array_merge([
            'grant_type' => 'password',
            'client_id' => '9263a3d5-1a7a-487d-b2fe-f7c5e4200e5a',
            'client_secret' => 'NmaWaGMKviSAHU8F5rKnvlbeCGJ7BCzygx1MEXvB',
            'scope' => '',
        ],$data);
        try{
            $response = $this->http->post('http://zadmin.test/oauth/token', [
                'form_params' => $data,
            ]);
            $token = json_decode((string)$response->getBody(), true);
            return [
                'accessToken' => $token['access_token'],
                'expiresIn' => $token['expires_in'],
                'code' => $response->getStatusCode()
            ];
        }catch (\Exception $e){
            return [
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }

//        return response()->json([
//            'token'      => $token['access_token'],
//            'auth_id'    => md5($token['refresh_token']),
//            'expires_in' => $token['expires_in'],
//        ])->cookie('refreshToken', $token['refresh_token'], 14400, null, null, false, true);
    }
}
