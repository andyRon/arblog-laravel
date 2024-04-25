<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * 运行数据库迁移
     */
    public function run(): void
    {
        DB::table('posts')->truncate();

        Post::factory()->count(20)->create();
    }
}
