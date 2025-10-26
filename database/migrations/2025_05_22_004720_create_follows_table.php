<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'followed_id');
            $table->foreignIdFor(User::class, 'follower_id');
            $table->timestamps();

            $table->unique(['followed_id', 'follower_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
