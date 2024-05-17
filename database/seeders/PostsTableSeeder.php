<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * 运行数据库迁移
     */
    public function run(): void
    {
        $tags = Tag::all()->pluck('tag')->all();

        Post::truncate();  // 先清理表数据

        // 清除关系表
        DB::table('post_tag_pivot')->truncate();

        // 一次填充20篇文章
        // 为文章设置了随机标签
        Post::factory(20)->create()->each(function ($post) use ($tags) { // TODO
            if (mt_rand(1, 100) <= 30) {
                return;
            }

            shuffle($tags);
            $postTags = [$tags[0]];

            if (mt_rand(1, 100) <= 30) {
                $postTags[] = $tags[1];
            }

            $post->syncTags($postTags);
        });
    }
}
