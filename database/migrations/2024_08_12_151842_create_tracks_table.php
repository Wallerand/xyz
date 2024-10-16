<?php

use App\Models\User;
use App\Models\Week;
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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Week::class)->constrained('weeks')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('artist');
            $table->string('title');
            $table->string('url');
            $table->string('player')->nullable();
            $table->string('player_track_id')->nullable();
            $table->string('player_thumbnail_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
