<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 16:22
 */

namespace App\Service;
use App\Model\sysRole;
use Hyperf\Di\Annotation\Inject;
use App\Service\CommonService;
use Phper666\JwtAuth\Jwt;

class SysRoleService
{

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    /**
     * @Inject
     * @var CommonService
     */
    protected $commonService;

    /**
     * @Inject
     * @var SysUserService
     */
    protected $userService;

    /**
     * @Inject
     * @var SysRole
     */
    protected $sysRole;

    /**
     * 菜单列表
     * User: fin
     * Date: 2019/11/13
     * Time: 11:19
     * @param $listQuery
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function pageList($listQuery,$page = 1, $limit = 10){
        $admin_id = $this->jwt->getParserData()['user_id'];
        if($admin_id != 1){
            $listQuery["create_user_id"] = $admin_id;
        }
        $data = $this->commonService->pageList($this->sysRole,$listQuery, $page, $limit);
        return $data;
    }

    public function info($id){
        $data['role'] = $this->sysRole->find($id);
        $menuList = $data['role']->permissions;
        $menuIdList = array();
        foreach ($menuList as $val) {
            $menuIdList[] = $val['menu_id'];
        }

        $data['role']['menuIdList'] = $menuList;
        unset($data['permissions']);
        return $data;
    }

    /**
     * 根据用户获取角色列表
     * User: fin
     * Date: 2019/11/13
     * Time: 20:21
     * @return mixed
     */
    public function select($userid)
    {
        $data['list'] = $this->userService->getInfo($userid)->roles->toArray();
        //如果是该用户创建的角色，该用户具备分配权
        $childrenRole = $this->sysRole::query()->where(['create_user_id' => $userid])->get()->toArray();
        $data['list'] = array_merge($data['list'], $childrenRole);
        return $data;
    }

    public function save($data){
        $res = [
            'role_name' => $data['roleName'],
            'remark'=>$data['remark'],
            'create_user_id'=>1
        ];
        $role = $this->sysRole->create($res);
        //保存权限
        $role->grantPermission($data['menuIdList']);
        return true;
    }

    public function update($data){
        $role = $this->sysRole->find($data['roleId']);
        $role->update([
            'role_name' => $data['roleName'],
            'remark'=>$data['remark'],
        ]);

        //获取目前更新的角色的所有菜单
        $roleMenu = $role->permissions;
        //因为上传来的角色列表格式与我们数据库取得不一样，需要转换一下
        foreach ($roleMenu->toArray() as $menu) {
            $roleMenus[] = $menu['menu_id'];
        }

        //将上传来的角色列表和我们转换后的角色列表转换成集合，然后利用集合的差集算出需要增加和删除的权限有哪些
        $roleMenus = collect($roleMenus);
        $updateMenu = collect($data['menuIdList']);
        $addMenu = $updateMenu->diff($roleMenus);
        $deleteMenu = $roleMenus->diff($updateMenu);
        //批量增加菜单权限
        $role->grantPermission($addMenu->toArray());
        //批量删除菜单权限
        $role->deletePermission($deleteMenu->toArray());
    }

    public function delete($id){
        $roles = $this->sysRole->find($id);
        foreach ($roles as $key => $val) {
            //获取当前角色的所有权限
            $rolePermission = $val->permissions;
            $roleUsers = $val->users;
            //删除角色中间表中的权限
            $val->deletePermission($rolePermission);
            $val->deleteUser($roleUsers);
            //删除角色
            $val->delete();
        }
    }
}
