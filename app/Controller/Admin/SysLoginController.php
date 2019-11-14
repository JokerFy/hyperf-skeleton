<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/12
 * Time: 19:33
 */

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Request\LoginRequest;
use Phper666\JwtAuth\Jwt;
class SysLoginController extends AbstractController
{
    public function login(LoginRequest $request,Jwt $jwt)
    {
        //验证参数
        $data = $request->validated();
        //验证用户账号密码
        $admin = $request->loginValidate($data);
        $token = (string)$jwt->getToken($admin);
        //获取用户token并返回
        return $this->response->success(['token'=>$token]);
    }
}
