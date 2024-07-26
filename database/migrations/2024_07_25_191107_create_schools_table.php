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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('abreviation');
            $table->string('identity')->unique();
            $table->string('mobile')->unique();
            $table->string('fixe')->unique();
            $table->string('email')->unique();
            $table->integer('province_id');
            $table->integer('region_id');
            $table->integer('district_id');
            $table->integer('commune_id');
            $table->boolean('is_active')->default(true);
            $table->foreignUlid('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('tenant_id');
            $table->string('domaine');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
