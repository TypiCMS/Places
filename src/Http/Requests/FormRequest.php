<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Places\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'image_id' => ['nullable', 'integer'],
            'og_image_id' => ['nullable', 'integer'],
            'title.*' => ['nullable', 'max:255'],
            'slug.*' => ['nullable', 'alpha_dash', 'max:255', 'required_if:status.*,1', 'required_with:title.*'],
            'status.*' => ['boolean'],
            'summary.*' => ['nullable', 'max:1000'],
            'body.*' => ['nullable', 'max:20000'],
            'address' => ['nullable', 'max:1000'],
            'email' => ['nullable', 'email:rfc,dns', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'phone' => ['nullable', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
