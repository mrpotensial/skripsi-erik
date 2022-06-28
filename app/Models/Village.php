<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $fillable = ['district_id', 'nama_desa', 'koordinat_bidang_desa'];

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    public function guestLands()
    {
        return $this->hasMany(\App\Models\GuestLand::class);
    }
}
