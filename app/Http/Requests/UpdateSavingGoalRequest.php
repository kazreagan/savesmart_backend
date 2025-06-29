<?php

namespace App\Http\Requests;

use App\Models\SavingGoal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSavingGoalRequest extends FormRequest
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
        $rules = SavingGoal::$rules;
        
        // Modify deadline rule for existing goals
        // Allow the deadline to be in the past if updating
        $rules['deadline'] = 'required|date';
        
        return $rules;
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'Please select a user',
            'user_id.exists' => 'The selected user does not exist',
            'title.required' => 'Please provide a title for this saving goal',
            'target_amount.required' => 'Please specify a target amount',
            'target_amount.numeric' => 'Target amount must be a number',
            'target_amount.min' => 'Target amount must be greater than zero',
            'current_amount.numeric' => 'Current amount must be a number',
            'current_amount.min' => 'Current amount cannot be negative',
            'deadline.required' => 'Please specify a deadline',
            'deadline.date' => 'The deadline must be a valid date'
        ];
    }
}