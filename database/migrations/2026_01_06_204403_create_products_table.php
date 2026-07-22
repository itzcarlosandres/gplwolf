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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('full_description')->nullable();
            $table->enum('type', ['theme', 'plugin', 'gpl', 'premium'])->default('premium');
            $table->string('category'); // themes, plugins, etc.
            $table->decimal('price', 10, 2)->default(0);
            $table->string('demo_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('screenshots')->nullable();
            $table->json('features')->nullable();
            $table->string('version')->default('1.0.0');
            $table->string('wordpress_version')->nullable(); // Compatible WP version
            $table->boolean('is_active')->default(true);
            $table->integer('downloads_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('slug');
            $table->index('type');
            $table->index('category');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
