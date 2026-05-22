<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            
            // Validasi Email dengan pengecualian ID user saat ini agar tidak error saat save
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // Menambahkan validasi untuk Nomor Telepon (WA)
            'telepon' => [
                'required', 
                'string', 
                'max:15',
            ],

            // Menambahkan validasi untuk Alamat
            'alamat' => [
                'required', 
                'string',
            ],
        ];
    }

    /**
     * Custom message jika kamu ingin pesan error dalam Bahasa Indonesia (Opsional)
     */
    public function messages(): array
    {
        return [
            'telepon.required' => 'Nomor telepon wajib diisi untuk keperluan koordinasi warga.',
            'alamat.required' => 'Alamat lengkap wajib diisi sesuai domisili RT.',
        ];
    }
}