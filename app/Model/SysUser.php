<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $user_id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $mobile
 * @property string $status
 * @property int $create_user_id
 * @property string $create_time
 * @property string $nickname
 * @property string $avatar
 */
class SysUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['user_id' => 'integer', 'create_user_id' => 'integer'];

    protected $primaryKey = "user_id";

    //用户有哪些角色(多对多)
    public function roles()
    {
        return $this->belongsToMany(SysRole::class,'sys_user_role','role_id','user_id');
    }

    //用户的token
    public function usertoken(){
        return $this->hasOne('Token','user_id','user_id');
    }

    //判断是否有哪些角色
    public function isInRoles($roles)
    {
        //判断角色与用户的角色是否有交集，加双感叹号，如果是0则返回false
        return !!$roles->intersect($this->roles)->count();
    }

    //给用户分配角色
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    //取消用户分配的角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);

    }

    //判断用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

}
