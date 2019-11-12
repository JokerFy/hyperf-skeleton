<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 17:27
 */

namespace App\Controller\Admin;

use App\Request\LoginRequest;
use App\Request\UserInfoRequest;
use Hyperf\Di\Annotation\Inject;
use Phper666\JwtAuth\Jwt;
use App\Controller\AbstractController;
use App\Service\SysUserService;

class SysUserController extends AbstractController
{
    /**
     * @Inject
     * @var SysUserService
     */
    protected $sysUserService;

    public function login(LoginRequest $request,Jwt $jwt)
    {
        //验证参数
        $data = $request->validated();
        //验证用户账号密码
        $admin = $request->loginValidate($data);
        $token = (string)$jwt->getToken($admin);
        //获取用户token并返回
        return $this->response->json(['token'=>$token]);
    }

    /**
     * 用户信息
     */
    public function getInfo(UserInfoRequest $request)
    {
        $user_id = $request->validated()['user_id'];
        $model = $this->sysUserService->getInfo($user_id);

        return $this->response->json([
            'user' => $model
        ]);
    }
}
