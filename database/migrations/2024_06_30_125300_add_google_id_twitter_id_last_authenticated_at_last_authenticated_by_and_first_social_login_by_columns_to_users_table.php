<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->after('avatar', function($table) {
                $table->string('google_id')->nullable();
                $table->string('twitter_id')->nullable();
                $table->timestamp('last_authenticated_at')->nullable();
                $table->string('last_authenticated_by',255)->nullable();
                $table->string('first_social_login_by',255)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('twitter_id');
            $table->dropColumn('last_authenticated_at');
            $table->dropColumn('last_authenticated_by');
            $table->dropColumn('first_social_login_by');
        });
    }
};
