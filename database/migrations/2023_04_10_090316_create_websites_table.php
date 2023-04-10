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
        // websites table schema
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // users table schema
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });

        // subscriptions table schema
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('website_id');
            $table->timestamps();

            $table->unique(['user_id', 'website_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('website_id')->references('id')->on('websites');
        });

        // posts table schema
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->foreign('website_id')->references('id')->on('websites');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
        Schema::dropIfExists('users');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('posts');

    }
};
