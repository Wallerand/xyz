<?php

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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'host_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignIdFor(User::class, 'guest_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('code')->unique();
            $table->timestamp('created_at');
            $table->timestamp('consumed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
