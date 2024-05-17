<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 表单被提交后保存标签的业务逻辑代码
 */
class TagCreateRequest extends FormRequest
{
    /**
     * 验证用户是否经过登录认证
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 返回验证规则数组
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tag' => 'bail|required|unique:tags,tag',
            'title' => 'required',
            'subtitle' => 'required',
            'layout' => 'required',
        ];
    }
}
