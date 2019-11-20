<?php

declare(strict_types=1);

namespace App\Request;

use App\Constants\ErrorCode;
use App\Exception\RequestException;
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
        $admin = $this->sysUser::query()->where('username', $data['username'])->first();
        if(!$admin){
            throw new RequestException(['code'=>ErrorCode::USER_NOT_EXIST]);
        }
        $admin = $admin->toArray();
        if($admin['password'] != $this->common->setPassword($data['password'],$data['salt'])){
            throw new RequestException(['code'=>ErrorCode::USER_PASSWORD_INVALID]);
        }
        return $admin;
    }

}
