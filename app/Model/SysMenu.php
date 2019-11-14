<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $menu_id
 * @property int $parent_id
 * @property string $name
 * @property string $url
 * @property string $perms
 * @property int $type
 * @property string $icon
 * @property int $order_num
 */
class SysMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id','name','icon','url','perms','type','order_num'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['menu_id' => 'integer', 'parent_id' => 'integer', 'type' => 'integer', 'order_num' => 'integer'];

    protected $primaryKey = "menu_id";


    //菜单拥有哪些角色
    public function roles()
    {
        return $this->belongsToMany(SysRole::class,'sys_role_menu','role_id', 'menu_id');
    }

    //删除中间表中的menu权限
    public function deleteMenu($menu)
    {
        return $this->roles()->detach($menu);
    }
}
