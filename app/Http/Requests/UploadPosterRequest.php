<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPosterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'poster.*' => 'required|mimes:png,jpg,jpeg,svg',
            'categories' => 'required|array',
            'poster' => ['required', 'array', function ($attribute, $value, $fail) {                              
                
                $minFiles = 1;
                $maxFiles = 3;
    
                $fileCount = count($value);
    
                if ($fileCount < $minFiles || $fileCount > $maxFiles) {
                    $fail("The $attribute must have between $minFiles and $maxFiles files.");                    
                }

                foreach ($value as $index => $file) {                        
                    $fieldName = $file->getClientOriginalName();                    

                    // Check the size of each file
                    if (($file->getSize() / 1000) > 5000) {
                        $fail("The $fieldName field must not be greater than 5000 kilobytes.");
                    }
                }
            }],
        ];
    }
}
