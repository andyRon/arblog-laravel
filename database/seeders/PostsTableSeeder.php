<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * 运行数据库迁移
     */
    public function run(): void
    {
//        Post::truncate();  // 先清理表数据
        Post::factory(20)->create(); // 一次填充20篇文章
    }
}
