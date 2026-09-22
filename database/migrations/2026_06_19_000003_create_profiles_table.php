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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title'); // e.g. Data Analyst & Engineer
            $table->text('bio');
            $table->string('photo_path')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('email');
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('skills')->nullable(); // JSON string or text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
