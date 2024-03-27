<?php

use App\Models\Licence;
use App\Models\User;
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
        Schema::create('demande_licences', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('debut_licence');
            $table->foreignIdFor(Licence::class, 'licence_id');
            $table->foreignIdFor(User::class, 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_licences', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
