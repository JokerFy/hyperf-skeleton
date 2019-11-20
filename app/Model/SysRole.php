<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $role_id
 * @property string $role_name
 * @property string $remark
 * @property int $create_user_id
 * @property string $create_time
 */
class SysRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_name','remark','create_user_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['role_id' => 'integer', 'create_user_id' => 'integer'];

    protected $primaryKey = "role_id";

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(SysUser::class,'sys_user_role','role_id','user_id');
    }

    //当前角色的所有权限
    public function permissions()
    {
        return $this->belongsToMany(SysMenu::class, 'sys_role_menu', 'role_id', 'menu_id');
    }


    //给角色赋予权限
    public function grantPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    //取消角色与用户关联
    public function deleteUser($id)
    {
        return $this->users()->detach($id);
    }

    //取消角色赋予的权限
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    //判断角色是否有权限
    public function hasPermission($permission)
    {
        //判断集合中是否有某个对象
        return $this->permissions->contains($permission);
    }

}
