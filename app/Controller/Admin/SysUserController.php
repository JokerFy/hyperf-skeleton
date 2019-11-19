<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 17:27
 */

namespace App\Controller\Admin;

use App\Model\SysUser;
use App\Request\TestRequest;
use App\Request\SysUserRequest;
use App\Service\CommonService;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;
use App\Service\SysUserService;

use Hyperf\HttpServer\Contract\RequestInterface;
use OpenApi\Annotations\OpenApi;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\PathItem;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Response;
use Phper666\JwtAuth\Jwt;

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
     * @Inject
     * @var SysUser
     */
    protected $sysUser;

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    public function list($page = 1, $limit = 10)
    {
        $listQuery = $this->request->getQueryParams();
        $data = $this->sysUserService->pageList($listQuery, $page, $limit);
        return $this->response->successNotify($data);
    }

    //增加用户
    public function save(SysUserRequest $request)
    {
        $this->sysUserService->save($request->validated());
        return $this->response->successNotify();
    }

    //更新用户
    public function update(SysUserRequest $request)
    {
//        return $this->response->successNotify($this->request->all());
        return $this->response->successNotify($request->validated());
        $this->sysUserService->update($request->validated());
        return $this->response->successNotify();
    }

    //删除用户(可批量)
    public function delete(SysUserRequest $request)
    {
        $this->sysUserService->delete($request->validated()['id']);
        return $this->response->successNotify();
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
     *       description="",
     *       @Parameter(name="id",in="query",description="用户id",required=true,type="integer",format="int64"),
     *     ),
     * )
     */
    public function getInfo(Jwt $jwt)
    {
        $user_id = $jwt->getParserData()['user_id'];

        $model = $this->sysUserService->getInfo($user_id);

        return $this->response->successNotify([
            'user' => $model
        ]);
    }

    public function getInfoById(SysUserRequest $request)
    {
        $model = $this->sysUserService->getInfo($request->validated()['id']);

        return $this->response->successNotify([
            'user' => $model
        ]);
    }

    public function test($id, TestRequest $request)
    {
        return $this->response->json([
            'user' => $id
        ]);
    }

}
