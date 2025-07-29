<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules(): array
  {
    return [
      'name' => 'sometimes|required|string|max:255',
      'sku' => 'sometimes|required|string|max:255|unique:products,sku,' . $this->product,
      'price' => 'sometimes|required|numeric|min:0',
      'stock_quantity' => 'sometimes|required|integer|min:0',
    ];
  }

  /**
   * @param Validator $validator
   * @return mixed
   * @throws ValidationException
   */
  protected function failedValidation(Validator $validator): mixed
  {
    throw new ValidationException($validator, response()->json($validator->errors(), 422));
  }
}

