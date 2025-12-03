<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique();
            $table->date('birthday')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'birthday',
                'profile_photo_path',
                'bio',
                'is_admin',
            ]);
        });
    }
};
