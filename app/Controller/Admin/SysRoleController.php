<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 17:27
 */

namespace App\Controller\Admin;

use App\Request\SysRoleRequest;
use App\Service\CommonService;
use App\Service\SysRoleService;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;

use Phper666\JwtAuth\Jwt;

class SysRoleController extends AbstractController
{

    /**
     * @Inject
     * @var SysRoleService
     */
    protected $roleService;

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    public function list($page = 1, $limit = 10)
    {
        $data = $this->roleService->pageList([], $page, $limit);
        return $this->response->successNotify($data);
    }

    //获得角色信息
    public function info(SysRoleRequest $request)
    {
        $data = $this->roleService->info($request->validated()['id']);
        return $this->response->successNotify($data);
    }

    //获取上级菜单
    public function select(Jwt $jwt)
    {
        $user_id = $jwt->getParserData()['user_id'];
        $data = $this->roleService->select($user_id);
        return $this->response->successNotify($data);
    }

    //添加角色
    public function save(SysRoleRequest $request)
    {
        $this->roleService->save($request->validated());
        return $this->response->successNotify();
    }

    //修改角色
    public function update(SysRoleRequest $request)
    {
        $this->roleService->update($request->validated());
        return $this->response->successNotify();
    }

    //删除角色
    public function delete(SysRoleRequest $request)
    {
        $this->roleService->delete($request->validated()['id']);
        return $this->response->successNotify();
    }

}
