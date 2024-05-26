<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropForeign(['penjualans_user_id_foreign', 'penjualans_pelanggan_id_foreign']);
        });
    }
};
