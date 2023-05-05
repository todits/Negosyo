<?php

namespace App\Http\Requests;

use App\Models\Batch;
use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'item' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            'total' => ['required'],
            'datepurchase' => ['required'],
            'batch_id' => ['nullable']


        ];
    }
}
