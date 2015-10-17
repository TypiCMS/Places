<?php

namespace TypiCMS\Modules\Places\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            'email'   => 'email',
            'website' => 'url',
            'image'   => 'image|max:2000',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.slug'] = [
                'required_with:'.$locale.'.title',
                'required_if:'.$locale.'.status,1',
                'alpha_dash',
                'max:255',
            ];
            $rules[$locale.'.title'] = 'max:255';
        }

        return $rules;
    }
}
