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
        Schema::create('posts', function (Blueprint $table) {
            $table->comment('文章表');
            $table->id();
            $table->string('slug')->unique()->comment('将文章标题转化为 URL 的一部分，以利于SEO');
            $table->string('title');
            $table->text('content');
            $table->softDeletes()->comment('用于支持软删除');  // 字段 deleted_at
            $table->timestamp('published_at')->nullable()->comment('文章正式发布时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
