<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_land_id',
        'path',
    ];

    public function guestland()
    {
        return $this->belongsTo(\App\Models\GuestLand::class);
    }
}
