<?php

namespace App\Http\Requests\Order;

use App\Role;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return auth()->user()?->role === Role::Customer->value;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'items' => 'required|array',
      'items.*.product_id' => 'required|exists:products,id',
      'items.*.quantity' => 'required|integer|min:1',
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
