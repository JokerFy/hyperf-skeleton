<?php
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class SysUserRequest extends FormRequest
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
                    'username'=> ['required','between:4,15'],
                    'password'=> ['required','between:4,15'],
                    'status'=> ['required','numeric'],
                    'mobile'=>['required','numeric'],
                    'email'=>['email'],
                    'roleIdList'=>['required','array'],
                ];
            case 'PUT':
                return [
                    'user_id' => ['required',Rule::exists('sys_user','user_id')],
                    'username'=> ['required','between:4,15'],
                    'password'=> ['required','between:4,15'],
                    'status'=> ['required','numeric'],
                    'mobile'=>['required','numeric'],
                    'email'=>['email'],
                    'roleIdList'=>['required','array'],
                ];
            case 'GET':
                return [
                    'id' => ['required',Rule::exists('sys_user','user_id')],
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
