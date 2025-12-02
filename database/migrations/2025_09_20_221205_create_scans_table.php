<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'lambat', 'sakit', 'izin', 'alpha'])->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'tanggal']); // 1 hari 1 data
        });
    }

    public function down()
    {
        Schema::dropIfExists('scans');
    }
};
