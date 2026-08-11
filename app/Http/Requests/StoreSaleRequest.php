<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSaleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount_received' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::in(['efectivo', 'yape'])],        
            'products' => ['required','array','min:1',],
            'products.*.product_id' => ['required','exists:products,id'],
            'products.*.quantity' => ['required','integer','min:1'],
        ];
    }
}
