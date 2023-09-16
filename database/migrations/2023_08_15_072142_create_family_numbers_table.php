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
        Schema::create('family_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('toddlers_number')->default(0);
            $table->unsignedInteger('pus_number')->default(0);
            $table->unsignedInteger('wus_number')->default(0);
            $table->unsignedInteger('blind_people_number')->default(0);
            $table->unsignedInteger('pregnant_women_number')->default(0);
            $table->unsignedInteger('breastfeeding_mother_number')->default(0);
            $table->unsignedInteger('elderly_number')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_numbers');
    }
};
