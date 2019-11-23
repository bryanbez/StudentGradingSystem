<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateStudentInfo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txtLRN' => 'required|digits:8|numeric',
            'txtLastName' => 'required|max:50|alpha',
            'txtFirstName' => 'required|max:50|alpha',
            'txtMiddleName' => 'required|max:50|alpha',
            'txtAge' => 'required|digits_between:1,2|numeric',
            'sltGender' => 'required',
            'sltYear' => 'required',
            'txtSection' => 'required|digits_between:1,2|numeric',
            'txtBldgRmNo' => 'required'
        ];
    }
    public function messages() {
        return [
            'txtLRN.required' => 'Student LRN is required',
            'txtLRN.max' => 'Student LRN must have exact 8 numerical digits',
            'txtLRN.numeric' => 'Student LRN must be in numeric form',
            'txtLastName.required' => 'Lastname field is required',
            'txtLastName.max' => 'LastName characters requires less than 50 characters',
            'txtLastName.alpha' => 'LastName accepts characters only',
            'txtFirstName.required' => 'Firstname field is required',
            'txtFirstName.max' => 'FirstName characters requires less than 50 characters',
            'txtFirstName.alpha' => 'FirstName accepts characters only',
            'txtMiddleName.required' => 'Middlename field is required',
            'txtMiddleName.max' => 'MiddleName characters requires less than 50 characters',
            'txtMiddleName.alpha' => 'MiddleName accepts characters only',
            'txtAge.required' => 'Age field is required',
            'txtAge.digits_between' => 'Age characters requires less than 3 characters',
            'txtAge.numeric' => 'Age field requires numeric input only',
            'sltGender.required' => 'Gender field is required',
            'sltYear.required' => 'Year field is required',
            'txtSection.required' => 'Section field is required',
            'txtSection.digits_between' => 'Section characters requires less than 2 characters',
            'txtSection.numeric' => 'Section field requires numeric input only',
            'txtBldgRmNo.required' => 'Building/ Room No field is required',
        ];
    }
}
