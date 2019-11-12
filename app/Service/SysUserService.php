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

class SysUserService
{

    /**
     * @Inject
     * @var SysUser
     */
    protected $sysUser;

    public function getInfo($id = 0){
        $data = $this->sysUser::with('roles')->find($id);
        //roles是目前登录用户拥有的角色列表，roleIdList是获取的指定用户所拥有的角色列表
        foreach ($data['roles']->toArray() as $val) {
            $roleIdList[] = $val['role_id'];
        }
        $data['roleIdList'] = isset($roleIdList) ? $roleIdList : [];
        return $data;
    }

}
