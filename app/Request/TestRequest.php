<?php
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class TestRequest extends FormRequest
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
                // UPDATE
                return [
                    'title1'       => 'required|min:2',
                    'body1'        => 'required|min:3',
                    'category_id1' => 'required|numeric',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                        'title'       => 'required|min:2',
                        'body'        => 'required|min:3',
                        'category_id' => 'required|numeric',
                ];
            case 'GET':
                return [
                    'id' => ['required'],
                ];
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }
}
