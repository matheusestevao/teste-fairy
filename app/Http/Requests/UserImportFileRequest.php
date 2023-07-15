<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserImportFileRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:csv'
        ];
    }

    public function message(): array
    {
        return [
            'file.requied' => 'Obrigatório informar um arquivo. E o mesmo tem que ser com a extensão CSV',
            'file.mimes' => 'A extensão do arquivo, não é permitida. Favor enviar arquivo com a(s) seguinte(s) extensão(es): CSV'
        ];
    }
}
