<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\GuestLand::class);
            $table->string('judul_pekerjaan');
            $table->bigInteger('status_pekerjaan');
            $table->longText('batas_waktu_pekerjaan')->nullable();
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
        Schema::dropIfExists('status_pekerjaans');
    }
}
