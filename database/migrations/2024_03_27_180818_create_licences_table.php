<?php

use App\Models\Produit;
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
        Schema::create('licences', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('libelle', 75);
            $table->float('prix');
            $table->integer('duree');
            $table->foreignIdFor(Produit::class, 'produit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licences', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
