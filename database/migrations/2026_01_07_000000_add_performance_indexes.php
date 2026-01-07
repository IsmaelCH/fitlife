<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Index for news queries - published_at is used for ordering
        Schema::table('news', function (Blueprint $table) {
            $table->index('published_at');
            $table->index(['user_id', 'published_at']);
        });

        // Index for news_comments - frequently joined with news and user
        Schema::table('news_comments', function (Blueprint $table) {
            $table->index(['news_id', 'created_at']);
        });

        // Index for contacts - ordered by created_at
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('created_at');
        });

        // Index for faqs - joined with category
        Schema::table('faqs', function (Blueprint $table) {
            $table->index('faq_category_id');
        });

        // Index for profile_posts - ordered by created_at and filtered by users
        Schema::table('profile_posts', function (Blueprint $table) {
            $table->index(['profile_user_id', 'created_at']);
            $table->index('author_user_id');
        });

        // Index for users - frequently searched by email and username
        Schema::table('users', function (Blueprint $table) {
            $table->index('username');
            $table->index('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
            $table->dropIndex(['user_id', 'published_at']);
        });

        Schema::table('news_comments', function (Blueprint $table) {
            $table->dropIndex(['news_id', 'created_at']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['faq_category_id']);
        });

        Schema::table('profile_posts', function (Blueprint $table) {
            $table->dropIndex(['profile_user_id', 'created_at']);
            $table->dropIndex(['author_user_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['username']);
            $table->dropIndex(['is_admin']);
        });
    }
};
