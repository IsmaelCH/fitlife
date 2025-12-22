<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_posts', function (Blueprint $table) {
            $table->id();

            // Profile owner (recipient)
            $table->foreignId('profile_user_id')->constrained('users')->cascadeOnDelete();

            // Author (writer)
            $table->foreignId('author_user_id')->constrained('users')->cascadeOnDelete();

            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_posts');
    }
};
