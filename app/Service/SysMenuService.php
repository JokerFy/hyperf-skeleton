<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 16:22
 */

namespace App\Service;
use App\Model\SysMenu;
use Hyperf\Di\Annotation\Inject;
use App\Service\CommonService;

class SysMenuService
{

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
     * @var SysMenu
     */
    protected $sysMenu;

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
        $data = $this->sysMenu::all();
        //给菜单增加一个上级菜单的属性
        foreach ($data as $key => $val) {
            foreach ($data as $item) {
                if ($val['parent_id'] == $item['menu_id']) {
                    $data[$key]['parent_name'] = $item['name'];
                } elseif ($val['parent_id'] == 0) {
                    $data[$key]['parent_name'] = '';
                }
            }
        }
        return ['menu'=>$data];
    }

    public function info($id){
        return ['menu'=>$this->sysMenu->find($id)];
    }

    public function select()
    {
        $data = $this->sysMenu::all();
        //给菜单增加一个上级菜单的属性
        foreach ($data as $key => $val) {
            foreach ($data as $item) {
                if ($val['parent_id'] == $item['menu_id']) {
                    $data[$key]['parent_name'] = $item['name'];
                } elseif ($val['parent_id'] == 0) {
                    $data[$key]['parent_name'] = '';
                }
            }
        }
        return ['menuList'=>$data];
    }

    public function save($data){
        $res = [
            'parent_id'=>$data['parentId'],
            'name'=>$data['name'],
            'icon'=>$data['icon'],
            'url'=>$data['url'],
            'perms'=>$data['perms'],
            'type'=>$data['type'],
            'order_num'=>$data['orderNum']
        ];
        return $this->sysMenu->create($res);
    }

    public function update($data){
        $menu = $this->sysMenu->find($data['menuId']);
        $menu->update([
            'parent_id'=>$data['parentId'],
            'name'=>$data['name'],
            'icon'=>$data['icon'],
            'url'=>$data['url'],
            'perms'=>$data['perms'],
            'type'=>$data['type'],
            'order_num'=>$data['orderNum']
        ]);
    }

    public function delete($id){
        $menu = $this->sysMenu->find($id);
        $childMenu = $this->sysMenu::query()->where(['parent_id'=>$id])->get();
        //获取菜单在中间表匹配的角色
        $menusRole = $menu->roles;
        //删除中间表和菜单表数据
        $menu->deleteMenu($menusRole);
        $menu->delete();
        foreach ($childMenu as $val){
            $childMenuRole = $val->roles;
            $val->deleteMenu($childMenuRole);
            $val->delete();
        }
    }


    public function nav($userid)
    {
        $userPermisson = $this->userService->userPermission($userid);
        //对菜单进行二级递归排序
        $menuList = $this->commonService->treeData($userPermisson['userPermission']);
        $data = ['menuList' => $menuList, 'permissions' => $userPermisson['userAccess']];
        return $data;
    }

}
