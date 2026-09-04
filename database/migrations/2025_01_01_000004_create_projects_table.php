<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->string('client')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('video')->nullable();
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->text('approach')->nullable();
            $table->text('result')->nullable();
            $table->json('technologies')->nullable();
            $table->smallInteger('year')->unsigned()->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_featured');
            $table->index('is_published');
            $table->index('published_at');
            $table->index('sort_order');
            $table->index('year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
