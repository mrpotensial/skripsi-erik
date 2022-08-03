<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranPermohonanRequest extends FormRequest
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
        return [
            'nama_pemilik' => ['required', 'string', 'max:255'],
            'nomor_sertifikat' => ['required', 'numeric', 'regex:/^[0-9]+$/', 'unique:guest_lands,nomor_sertifikat'],
            'nib' => ['required', 'numeric', 'regex:/^[0-9]+$/', 'unique:guest_lands,nib'],
            'village_id' => ['required', 'numeric'],
            'nomor_telpon' => ['required', 'regex:/^[0-9]{10,15}$/', 'min:10', 'max:15'],
            'nomor_hak' => ['nullable', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'nama_pemilik.required' => 'Nama Pemilik tidak boleh kosong',
            'nama_pemilik.string' => 'Nama Pemilik harus berupa string',
            // 'nama_pemilik.regex' => 'Nama Pemilik hanya boleh berupa huruf',
            'nama_pemilik.max' => 'Nama Pemilik maksimal 255 karakter',
            'nomor_sertifikat.required' => 'Nomor Sertifikat tidak boleh kosong',
            'nomor_sertifikat.numeric' => 'Nomor Sertifikat harus berupa angka',
            'nomor_sertifikat.regex' => 'Nomor Sertifikat harus berupa angka',
            'nomor_sertifikat.unique' => 'Nomor Sertifikat sudah terdaftar',
            'nib.required' => 'NIB tidak boleh kosong',
            'nib.numeric' => 'NIB harus berupa angka',
            'nib.regex' => 'NIB harus berupa angka',
            'nib.unique' => 'NIB sudah terdaftar',
            'village_id.required' => 'Desa tidak boleh kosong',
            'village_id.numeric' => 'Desa harus berupa angka',
            'nomor_telpon.required' => 'Nomor Telpon tidak boleh kosong',
            'nomor_telpon.regex' => 'Nomor Telpon tidak valid',
            'nomor_telpon.min' => 'Nomor Telpon minimal 10 digit',
            'nomor_telpon.max' => 'Nomor Telpon maksimal 15 digit',
            // 'nomor_hak.required' => 'Nomor Hak tidak boleh kosong',
            'nomor_hak.numeric' => 'Nomor Hak harus berupa angka',
        ];
    }
}
