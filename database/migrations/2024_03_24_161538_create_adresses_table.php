<?php

use App\Models\Ville;
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
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('numero');
            $table->string('rue', 75);
            $table->foreignIdFor(Ville::class, 'ville_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adresses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
