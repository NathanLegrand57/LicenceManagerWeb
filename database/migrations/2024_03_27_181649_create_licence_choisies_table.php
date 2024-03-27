<?php

use App\Models\Licence;
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
        Schema::create('licences_choisies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignIdFor(Licence::class, 'licence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licences_choisies', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
