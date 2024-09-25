<?php

namespace App\Http\Requests\Antrian;

use Illuminate\Foundation\Http\FormRequest;

class QueueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_polisi' => 'required|string|max:50',
            'jenis_antrian' => 'required|in:GR,BP',
            'name' => 'required_if:user_id,null|string|max:255',
            'address' => 'required_if:user_id,null|string|max:255',
            'phone_number' => 'required_if:user_id,null|string|max:15',
        ];
    }
}
