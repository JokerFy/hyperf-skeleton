<?php
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class SysMenuRequest extends FormRequest
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
                    'parentId'=> ['required','numeric'],
                    'name'=> ['required','between:4,15'],
                    'url'=> ['required'],
                    'perms'=> ['required'],
                    'type'=> ['required'],
                ];
            case 'PUT':
                return [
                    'parentId'=> ['required','numeric'],
                    'name'=> ['required','between:4,15'],
                    'url'=> ['required'],
                    'perms'=> ['required'],
                    'type'=> ['required'],
                ];
            case 'GET':
                return [
                    'id' => ['required',Rule::exists('sys_menu','menu_id')],
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
