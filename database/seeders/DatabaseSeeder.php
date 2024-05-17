<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();  // 取消批量赋值白名单、黑名单属性校验

        $this->call(TagsTableSeeder::class);
        $this->call(PostsTableSeeder::class);

        Model::reguard(); // 恢复校验
    }
}
