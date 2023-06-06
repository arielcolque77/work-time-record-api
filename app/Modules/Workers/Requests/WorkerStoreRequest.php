<?php

namespace App\Modules\Workers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'color' => ['required'],
            'code' => ['required'],
        ];
    }
}
