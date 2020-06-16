<?php

namespace App\Http\Requests\Api;

class AgendarFreteRequest extends ApiFormRequest
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
        return [
            "origem_latitude" => 'required',
            "origem_longitude" => 'required',
            "destino_latitude" => 'required',
            "destino_longitude" => 'required',
            "distancia" => 'required',
            "tipo_veiculo" => 'required',
            "data_frete" => 'required',
        ];
    }
}
