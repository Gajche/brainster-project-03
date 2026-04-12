<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewApplicationRequest extends FormRequest
{
	public function authorize(): bool
	{
		return Auth::check();
	}

	public function rules(): array
	{
		return [
			'decision'       => 'required|in:approved,rejected',
			'admin_response' => 'required|string|min:10|max:2000',
		];
	}

	public function messages(): array
	{
		return [
			'decision.required'       => 'Изберете одлука (одобри/одбиј).',
			'decision.in'             => 'Невалидна одлука.',
			'admin_response.required' => 'Пораката до уметникот е задолжителна.',
			'admin_response.min'      => 'Пораката мора да содржи барем 10 знаци.',
		];
	}
}
