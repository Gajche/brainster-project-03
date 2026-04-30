<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistApplicationRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true; // Public form - no auth required
	}

	public function rules(): array
	{
		return [
			'name'               => 'required|string|max:100',
			'surname'            => 'required|string|max:100',
			// e-mail format validation + domain check (user@example.com and mail exchange records in dns config)
			'email'              => 'required|email:rfc,dns|max:255',
			'phone'              => 'nullable|string|max:30|regex:/^[0-9\+\-\s\(\)]+$/',
			'social_media'       => 'nullable|url|max:500',
			'collaboration_area' => 'required|string|max:255',
			'message'            => 'required|string|max:5000',
			// Only PDF, DOC, DOCX files; max 2MB
			// Portfolio File: Required ONLY IF portfolio_url is empty
			'portfolio' => 'nullable|file|mimes:pdf,doc,docx|max:2048',

			// Portfolio URL: Required ONLY IF portfolio is empty
			'portfolio_url' => 'nullable|url|max:255',
		];
	}

	public function messages(): array
	{
		return [
			'name.required'               => 'Името е задолжително.',
			'surname.required'            => 'Презимето е задолжително.',
			'email.required'              => 'Е-поштата е задолжителна.',
			'email.email'                 => 'Внесете валидна е-пошта.',
			'collaboration_area.required' => 'Областа на соработка е задолжителна.',
			'message.required'            => 'Пораката е задолжителна.',
			'portfolio.mimes'             => 'Дозволени се само PDF, DOC и DOCX датотеки.',
			'portfolio.max'               => 'Датотеката не смее да биде поголема од 2MB.',
			'phone.regex'                 => 'Внесете валиден телефонски број.',
		];
	}

	/**
	 * Rate limiting: max 3 submissions per IP per hour.
	 */
	protected function prepareForValidation(): void
	{
		// Sanitize text fields
		$this->merge([
			'name'    => strip_tags($this->name ?? ''),
			'surname' => strip_tags($this->surname ?? ''),
			'message' => strip_tags($this->message ?? ''),
		]);
	}
}
