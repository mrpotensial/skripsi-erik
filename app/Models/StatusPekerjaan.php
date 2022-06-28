<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPekerjaan extends Model
{
    use HasFactory;
    protected $fillable = ['guest_land_id', 'status_pekerjaan', 'judul_pekerjaan',  'status_pekerjaan', 'batas_waktu_pekerjaan'];

    public function guesLand()
    {
        return $this->belongsTo(\App\Models\GuestLand::class);
    }

    public static function store_perubahan_data($data)
    {
        // dd($data->judul_status_proses);
        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $data->id,
            'judul_pekerjaan' => $data->judul_status_proses,
            'status_pekerjaan' => $data->status_proses,
            'batas_waktu_pekerjaan' => $data->batas_waktu_proses,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
