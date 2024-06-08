<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',            
            'poster.*' => 'required|mimes:png,jpg,jpeg,svg',
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


