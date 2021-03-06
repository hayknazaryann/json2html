<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateListRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->request->all();
        $rules = [];

        if (array_key_exists('json_input_type',$data)){
            if ($data['json_input_type'] == 'input'){
                $rules['json_data'] = 'required';
            }elseif ($data['json_input_type'] == 'file'){
                $rules['json_file'] = 'required|file|mimetypes:application/json';
            }
        }

        if (array_key_exists('background_input_type', $data)){
            if ($data['background_input_type'] == 'url'){
                $rules['background_url'] = 'url';
            }elseif ($data['background_input_type'] == 'rgb'){
                $rules['background_color'] = 'nullable|regex:/\((?:\s*\d+\s*,){2}\s*[\d]+\)/i';
            }
        }

        if (array_key_exists('depth', $data)){
            $rules['depth'] = "numeric|min:1";
        }

        return $rules;
    }
}
