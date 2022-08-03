<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestLand extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama_pemilik',
        'nomor_sertifikat',
        'nib',
        'village_id',
        'district_id',
        'nomor_telpon',
        'nomor_hak',
        'luas_tanah',
        'koordinat_bidang',
        'peta_bidang',
        'judul_status_proses',
        'status_proses',
        'batas_waktu_proses',
        'created_at',
    ]; //Boleh Diisi

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    public function village()
    {
        return $this->belongsTo(\App\Models\Village::class);
    }

    public function statusPekerjaans()
    {
        return $this->hasMany(\App\Models\StatusPekerjaan::class);
    }

    public function buktiPekerjaans()
    {
        return $this->hasMany(\App\Models\BuktiPekerjaan::class);
    }
}
