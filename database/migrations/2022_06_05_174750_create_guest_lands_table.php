<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_lands', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable();
            $table->longText('nama_pemilik');
            $table->string('nomor_sertifikat')->unique();
            $table->string('nib')->unique();
            $table->foreignIdFor(\App\Models\Village::class);
            $table->longText('nomor_telpon');
            $table->string('nomor_hak')->nullable();
            $table->longText('luas_tanah')->nullable();
            $table->longText('koordinat_bidang')->nullable();
            $table->longText('peta_bidang')->nullable();
            $table->bigInteger('status_proses')->default('0');
            $table->string('judul_status_proses')->default('Pendaftaran Berkas');
            $table->longText('batas_waktu_proses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_lands');
    }
}
