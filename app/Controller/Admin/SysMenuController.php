<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 17:27
 */

namespace App\Controller\Admin;

use App\Model\SysUser;
use App\Request\SysMenuRequest;
use App\Service\CommonService;
use App\Service\SysMenuService;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;

use Phper666\JwtAuth\Jwt;

class SysMenuController extends AbstractController
{

    /**
     * @Inject
     * @var SysMenuService
     */
    protected $sysMenuService;

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    public function list($page = 1, $limit = 10)
    {
        $data = $this->sysMenuService->pageList([], $page, $limit);
        return $this->response->successNotify($data);
    }

    //获得菜单信息
    public function info(SysMenuRequest $request)
    {
        $data = $this->sysMenuService->info($request->validated()['id']);
        return $this->response->successNotify($data);
    }

    //获取上级菜单
    public function select()
    {
        $data = $this->sysMenuService->select();
        return $this->response->successNotify($data);
    }

    //添加菜单
    public function save(SysMenuRequest $request)
    {
        $this->sysMenuService->save($request->validated());
        return $this->response->successNotify();
    }

    //修改菜单
    public function update(SysMenuRequest $request)
    {
        $this->sysMenuService->update($request->validated());
        return $this->response->successNotify();
    }

    //删除菜单（如果有子菜单则一起删除，包括中间表和菜单表）
    public function delete(SysMenuRequest $request)
    {
        $this->sysMenuService->delete($request->validated()['id']);
        return $this->response->successNotify();
    }

    /**
     * 根据用户的权限生成菜单树（因为前后端分离，所以这里相当于是获取了给前端显示菜单的路由）
     * menulist是用户的路由菜单权限，前端根据该数值动态显示菜单
     * permissions是用户的访问权限，前端根据该值判断用户能访问后端的哪些路由，并且根据权限判断是否显示增加删除等按钮
     * User: fin
     * Date: 2019/11/13
     * Time: 20:06
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function nav(Jwt $jwt)
    {
        $data = $this->sysMenuService->nav($jwt->getParserData()['user_id']);
        return $this->response->successNotify($data);
    }

}
