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
        Schema::table('users', function (Blueprint $table) {
            $table->after('role_id', function ($table) {
                $table->unsignedSmallInteger('province_id', false)->nullable();
                $table->unsignedInteger('regency_id', false)->nullable();
                $table->unsignedBigInteger('district_id', false)->nullable();
                $table->unsignedBigInteger('village_id', false)->nullable();

                $table->foreign('province_id')->references('id')->on('provinces');
                $table->foreign('regency_id')->references('id')->on('regencies');
                $table->foreign('district_id')->references('id')->on('districts');
                $table->foreign('village_id')->references('id')->on('villages');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id']);
            $table->dropForeign(['province_id', 'regency_id', 'district_id', 'village_id']);
        });
    }
};
