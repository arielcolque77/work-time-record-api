<?php

namespace App\Modules\PeriodsWorked\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodWorkedUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'worker_id' => ['required', 'numeric'],
            'start_time' => ['required'],
            'end_time' => ['nullable'],
        ];
    }
}
