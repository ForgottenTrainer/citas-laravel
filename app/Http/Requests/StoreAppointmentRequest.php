<?php

namespace App\Http\Requests;

use App\Appointment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'client_id'   => [
                'required',
                'integer',
            ],
            'start_time'  => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'finish_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'services.*'  => [
                'integer',
            ],
            'services'    => [
                'array',
            ],
            'employee_id' => [
                'required',
                Rule::unique('appointments')->where(function ($query) {
                    return $query->where('employee_id', $this->employee_id)
                        ->where('start_time', $this->start_time);
                }),
            ],
        ];
    }
}
