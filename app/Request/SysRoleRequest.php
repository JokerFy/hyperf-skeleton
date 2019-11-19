<?php
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class SysRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        switch($this->getMethod())
        {
            // CREATE
            case 'POST':
                return [
                    'roleName'=> ['required','between:4,15'],
                    'remark'=> ['required','between:4,50'],
                    'menuIdList'=>'required'
                ];
            case 'PUT':
                return [
                    'roleId'=> ['required',Rule::exists('sys_role','role_id')],
                    'roleName'=> ['required','between:4,15'],
                    'remark'=> ['required','between:4,50'],
                    'menuIdList'=>'required'
                ];
            case 'GET':
                return [
                    'id' => ['required',Rule::exists('sys_role','role_id')],
                ];
            case 'DELETE':
                return [
                    'id' => ['required'],
                ];
            default:
                {
                    return [];
                };
        }
    }
}
