<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name'=>trans('cruds.user.fields.name'),
            'email'=>trans('cruds.user.fields.email'),
            'password'=>trans('cruds.user.fields.password'),
            'roles'=>trans('cruds.user.fields.roles'),
            'supervisor_id' =>trans('cruds.user.fields.supervisor')
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roles' => 'required'
        ];
    }
}
