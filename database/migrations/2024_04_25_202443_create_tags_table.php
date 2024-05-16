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
        Schema::create('tags', function (Blueprint $table) {
            $table->comment('标签表');
            $table->id();
            $table->string('tag')->unique();
            $table->string('title');
            $table->string('subtitle');
            $table->string('page_image')->comment('标签图片');
            $table->string('meta_description')->comment('标签介绍');
            $table->string('layout')->default('blog.layouts.index')->comment('布局');
            $table->boolean('reverse_direction')->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
