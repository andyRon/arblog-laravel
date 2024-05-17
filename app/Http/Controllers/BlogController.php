<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
//        $posts = DB::table('posts')->where('published_at', '<=', Carbon::now())
//            ->orderBy('published_at', 'desc')
//            ->paginate(config('blog.posts_per_page'));
//
//        return view('blog.index', compact('posts'));

        $tag = $request->get('tag');
        $postService = new PostService($tag);
        $data = $postService->lists();
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        return view($layout, $data);
    }

    /**
     * 显示文章详情
     */
    public function showPost($slug, Request $request): View
    {
//        $post = DB::table('posts')->where('slug', $slug)->first();
//        return view('blog.post', ['post' => $post]);

        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::where('tag', $tag)->firstOrFail();
        }
        return view($post->layout, compact('post', 'tag'));
    }
}
