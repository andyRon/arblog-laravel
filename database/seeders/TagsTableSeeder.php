<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{

    public function run()
    {
        Tag::truncate();

        Tag::factory(5)->create();
    }
}
