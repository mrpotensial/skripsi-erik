<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kecamatan', 'koordinat_bidang_kecamatan'];

    public function villages()
    {
        return $this->hasMany(\App\Models\Village::class);
    }

    public function guestLands()
    {
        return $this->hasMany(\App\Models\GuestLand::class);
    }
}
