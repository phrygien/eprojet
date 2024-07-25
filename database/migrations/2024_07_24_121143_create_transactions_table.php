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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('numero_transaction')->unique();
            $table->timestamp('date_transac');
            $table->string('num_transac_partenaire');
            $table->foreignId('partenaire_id')->constrained('partenaires')->onDelete('cascade');
            $table->foreignId('abonnement_id')->constrained('abonnements')->onDelete('cascade');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('status');
            $table->text('commentaire')->nullable();
            $table->string('mpgw_token');
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
