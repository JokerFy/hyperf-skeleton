<?php

declare(strict_types=1);

namespace App\Request;

use App\Constants\ErrorCode;
use App\Exception\ParameterException;
use App\Exception\ParamException;
use App\Exception\Handler\BaseException;
use App\Model\SysUser;
use App\Kernel\Http\Response;
use App\Service\CommonService;
use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;
use Hyperf\Di\Annotation\Inject;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @Inject
     * @var SysUser
     */
    protected $sysUser;

    /**
     * @Inject
     * @var CommonService
     */
    protected $common;

    /**
     * @Inject
     * @var Response
     */
    protected $response;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username'=>['required','max:32'],
            'password'=>'required|max:16',
        ];
    }

    public function loginValidate($data)
    {

        $admin = $this->sysUser::query()->where('username', $data['username'])->first()->toArray();
        if(!$admin){
            throw new ParameterException(['msg'=>'账号不存在']);
        }
        if($admin['password'] != $this->common->setPassword($data['password'],$data['salt'])){
            throw new ParameterException(['msg'=>'密码错误']);
        }
        return $admin;
    }

}
