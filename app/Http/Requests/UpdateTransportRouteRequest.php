<?php

namespace App\Http\Requests;

use App\Models\TransportRoute;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTransportRouteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('transport_route_edit');
    }

    public function rules()
    {
        return [
            'route_name' => [
                'string',
                'required',
            ],
        ];
    }
}
