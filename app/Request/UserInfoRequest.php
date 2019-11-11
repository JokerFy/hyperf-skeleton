<?php
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class UserInfoRequest extends FormRequest
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
        return [
            'user_id' => ['required',Rule::exists('sys_user','user_id')],
        ];
    }
}
