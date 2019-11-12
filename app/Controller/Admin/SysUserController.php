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
use App\Controller\AbstractController;
use App\Service\SysUserService;

use OpenApi\Annotations\OpenApi;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\PathItem;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Response;
/**
 * @OpenApi(
 *     @Info(title="My First API", version="0.1")
 * )
 */
class SysUserController extends AbstractController
{
    /**
     * @Inject
     * @var SysUserService
     */
    protected $sysUserService;

    /**
     * 用户登录
     * @OpenApi(
     *     tags={"用户相关"},
     *     @PathItem(
     *       @Get(
     *          @Response(response="200")
     *       ),
     *       path="/sys/login",
     *       description="用户登录",
     *       @Parameter(name="username",in="formData",description="用户名",required=true,type="string",format="string"),
     *       @Parameter(name="password",in="formData",description="用户密码",required=true,type="number",format="number"),
     *     ),
     * )
     */
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
     * 获取用户信息
     * @OpenApi(
     *     tags={"用户相关"},
     *     @PathItem(
     *       @Get(
     *          @Response(response="200")
     *       ),
     *       path="/hy-admin/sys/user/info",
     *       description="一个用户列表",
     *       @Parameter(name="id",in="query",description="用户id",required=true,type="integer",format="int64"),
     *     ),
     * )
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
