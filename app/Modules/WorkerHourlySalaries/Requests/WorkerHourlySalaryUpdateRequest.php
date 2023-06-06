<?php

namespace App\Modules\WorkerHourlySalaries\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerHourlySalaryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'worker_id' => ['required', 'numeric'],
            'salary' => ['required'],
            'since' => ['required'],
        ];
    }
}
