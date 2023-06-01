<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|mimetypes:audio/x-wav,video/mpeg,video/x-msvideo,video/mp4,text/csv,image/gif,image/jpeg,application/pdf,zip,rar,image/webp,application/vnd.ms-excel,application/zip|max:50000'
        ];
    }
}
