<?php

namespace App\Http\Requests;

use App\Enums\ScheduleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'regex:/^7[0-9]{10}$/', 'unique:orders,client_phone'],
            'tarrif_id' => ['required', 'exists:tarrifs,id','integer'],
            'schedule_type' => ['required', 'string', Rule::in(ScheduleType::values())],
            'comment' => ['nullable', 'string'],
            'date_ranges' => ['required', 'array', 'min:1'],
            'date_ranges.*.from' => ['required', 'date', 'before_or_equal:date_ranges.*.to'],
            'date_ranges.*.to' => 'required|date|after_or_equal:date_ranges.*.from',
        ];
    }
}
