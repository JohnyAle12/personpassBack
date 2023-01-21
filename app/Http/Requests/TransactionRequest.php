<?php

namespace App\Http\Requests;

use App\Constants\TransactionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', new Enum(TransactionTypes::class)],
            'entity' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ];
    }
}
