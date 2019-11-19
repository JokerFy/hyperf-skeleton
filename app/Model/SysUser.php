<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use App\Service\CommonService;
use Hyperf\Di\Annotation\Inject;

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
     * @Inject
     * @var CommonService
     */
    protected $commonService;

    public $timestamps = false;
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
    protected $fillable = ['username','password','salt','email','mobile','create_user_id','status'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['user_id' => 'integer', 'create_user_id' => 'integer', 'status' => 'integer'];

    protected $primaryKey = "user_id";

    //用户有哪些角色(多对多)
    public function roles()
    {
        return $this->belongsToMany(SysRole::class,'sys_user_role','user_id','role_id');
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
        return $this->roles()->attach($role);
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

    //创建一个管理员并保存
    public function createUser($data){
        $salt = $this->commonService->getRandChar(20);
        $res = $this->create([
            'username' => $data['username'],
            'password' => $this->commonService->setPassword($data['password'], $salt),
            'salt' => $salt,
            'status'=>$data['status'],
            'mobile'=>$data['mobile'],
            'email'=>$data['email'],
            'create_user_id'=>1
        ]);
        return $res->user_id;
    }

    //更新管理员
    public function updateUser($data){
        $salt = $this->commonService->getRandChar(20);
        $user = self::query()->find($data['user_id']);
        $res = $user->update([
            'username' => $data['username'],
            'password' => $this->commonService->setpassword($data['password'], $salt),
            'salt' => $salt,
            'status'=>$data['status'],
            'mobile'=>$data['mobile'],
            'email'=>$data['email'],
        ]);
        return $res;
    }


}
