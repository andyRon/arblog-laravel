<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = DB::table('posts')->where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(config('blog.posts_per_page'));
        return view('blog.index', compact('posts'));
    }

    public function showPost($slug): View
    {
        $post = DB::table('posts')->where('slug', $slug)->first();
        return view('blog.post', ['post' => $post]);
    }
}
