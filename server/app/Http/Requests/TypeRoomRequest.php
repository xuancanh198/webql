<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class TypeRoomRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rule = []; 
        if ($this->isMethod('post') || $this->isMethod('put')) {
            $rule = [
                'name' => 'required|string|min:4|max:255',
            ];
            if($this->isMethod('put')){
                $rule['code'] = 'required|string|min:5|max:60|unique:tbl_type_room,code,' . $this->route('id');
            }
        } elseif ($this->isMethod('get')) {
            $rule = $this->getMethodGet();
        } elseif ($this->isMethod('delete')) {
            $rule =$this->getMethodDelete('tbl_type_room');
        }
        return $rule;
    }
    
    
    public function messages()
    {
        return $this->generateMessages($this->rules());
    }
    public function attributes()
    {
        $attributes = $this->attributesBase();
       return (array_merge($attributes, [
            'name' => trans('message.nameTypeRoom'), 
            'code' => trans('message.codeTypeRoom'), 
            'id' => trans('message.idTypeRoom'), 
        ]));
    }
}
