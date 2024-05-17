<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag', 'title', 'subtitle', 'page_image', 'meta_description','reverse_direction',
    ];


    /**
     * 定义文章与标签之间多对多关联关系
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag_pivot');
    }

    public static function addNeededTags(array $tags)
    {
        if (count($tags) === 0) {
            return;
        }

        $found = static::whereIn('tag', $tags)->get()->pluck('tag')->all();

        foreach (array_diff($tags, $found) as $tag) {
            static::create([
                'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for '.$tag,
                'page_image' => '',
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
    }


    /**
     * 返回标签的布局
     */
    public static function layout(string $tag, $default = 'blog.layouts.index')
    {
        $layout = static::where('tag', $tag)->get()->pluck('layout')->first();

        return $layout ?: $default;
    }
}
