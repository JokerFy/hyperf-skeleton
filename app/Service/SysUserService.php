<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 16:22
 */

namespace App\Service;
use App\Model\SysUser;
use Hyperf\Di\Annotation\Inject;
use App\Service\CommonService;

class SysUserService
{

    /**
     * @Inject
     * @var SysUser
     */
    protected $sysUser;

    /**
     * @Inject
     * @var CommonService
     */
    protected $commonService;

    /**
     * 用户列表
     * User: fin
     * Date: 2019/11/13
     * Time: 11:19
     * @param $listQuery
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function pageList($listQuery,$page = 1, $limit = 10){
        $data = $this->commonService->pageList($this->sysUser,$listQuery, $page, $limit);
        return $data;
    }

    public function getInfo($id = 0){
        $data = $this->sysUser::with('roles')->find($id);
        //roles是目前登录用户拥有的角色列表，roleIdList是获取的指定用户所拥有的角色列表
        foreach ($data['roles']->toArray() as $val) {
            $roleIdList[] = $val['role_id'];
        }
        $data['roleIdList'] = isset($roleIdList) ? $roleIdList : [];
        return $data;
    }

    /**
     * 新增管理员
     * User: fin
     * Date: 2019/11/1
     * Time: 20:58
     */
    public function save($data){
        $addUser = $this->sysUser->createUser($data);
        $user = $this->sysUser->find($addUser);
        //分配权限
        $user->assignRole($data['roleIdList']);
    }

    /**
     * 更新管理员
     * User: fin
     * Date: 2019/11/13
     * Time: 10:49
     */
    public function update($data){
        //更新用户
        $this->sysUser->updateUser($data);
        $user = $this->sysUser->find($data['user_id']);
        //获取目前更新的用户的所有角色
        $userRole = $user->roles;
        //因为上传来的角色列表格式与我们数据库取得不一样，需要转换一下
        if (!$userRole->isEmpty()) {
            foreach ($userRole->toArray() as $role) {
                $userRoles[] = $role['role_id'];
            }
            //将上传来的角色列表和我们转换后的角色列表转换成集合，然后利用集合的差集算出需要增加和删除的权限有哪些
            $userRoles = collect($userRoles);
            $updateRole = collect($data['roleIdList']);
            foreach ($userRoles as $role) {
                $user->deleteRole($role);
            }
            foreach ($updateRole as $role) {
                $user->assignRole($role);
            }
        } else {
            $user->assignRole($data['roleIdList']);
        }
        return true;
    }

    /**
     * 删除管理员
     * User: fin
     * Date: 2019/11/1
     * Time: 20:58
     */
    public function delete($userIds){
        $users = $this->sysUser::query()->find($userIds);
        foreach ($users as $key => $val) {
            //获取每个用户角色，然后删除
            $roles[$key] = $val->roles;
            $val->deleteRole($roles[$key]);
            $val->delete();
        }
    }

    //获取用户所有角色的所有权限
    public function userPermission($id)
    {
        //获取用户
        $user = $this->getInfo($id);
        //获取用户所有的角色
        $userRoles = $user->roles;

        //获取用户所有的菜单路由权限
        $userPermission = [];
        //获取用户所有的访问控制器方法的权限
        $userAccess = [];
        //$userRoles是一个二维数组，进行嵌套循环所有每个角色数组下的权限
        foreach ($userRoles as $key => $value) {
            foreach ($value->permissions as $item => $val) {
                $userPermission[] = $val;
                if ($val['perms'] != false) {
                    $userAccess[] = $val['perms'];
                }
            };
        }
        $userPermission = array_unique($userPermission);
        $userAccess = array_unique($userAccess);

        //对权限进行格式化
        foreach ($userAccess as $val) {
            $array = explode(',', $val);
            foreach ($array as $item) {
                $perms[] = $item;
            }
        }
        //去除重复权限并且重新对索引进行排序
        $userAccess = array_values(array_unique($perms));

        $data = [
            'userPermission' => $userPermission,
            'userAccess' => $userAccess
        ];
        return $data;
    }

}
