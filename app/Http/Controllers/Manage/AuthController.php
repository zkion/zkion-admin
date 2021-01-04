<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage;
use App\Traits\PassportProxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    use PassportProxy;

    public function login(Request $request)
    {
        $loginResult = Auth::guard('manage')->attempt([
            'name' => $request->name,
            'password' => $request->password,
        ]);
        if (!$loginResult) return $this->fail('用户名或密码错误！');
        $passportResult = $this->passport([
            'username' => $request->name,
            'password' => $request->password,
        ]);
        if ($passportResult['code'] == 200) {
            return $this->success(
                $passportResult,
                '登陆成功！'
            );
        }

        return $this->fail('登陆失败');
    }

    public function user(Request $request)
    {
        return $this->success($request->user('apm'));
    }

    public function logout(Request $request)
    {
        return $this->success([
            $request->user('apm')->token()->revoke()
        ]);
    }
}
