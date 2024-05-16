arblog-laravel
---



参考：https://laravelacademy.org/books/laravel-blog-tutorial

代码：https://github.com/andyRon/arblog-laravel



## 1 创建项目和测试驱动开发

```sh
composer create-project laravel/laravel arblog-laravel --prefer-dist 10.*
```

```sh
npm install
```



### 测试

运行默认的PHPUnit测试：

```sh
vendor/bin/phpunit
```

或在composer.json中添加相关配置后，运行`composer test`:

```json
"scripts": {
    "test" : [
        "vendor/bin/phpunit"
    ],
    ... 
},
```



Laravel项目根目录下`phpunit.xml` 是PHPUnit的配置信息，默认测试文件位于 `tests` 目录下

- `Unit/ExampleTest.php` —— 包含一个 `testBasicExample()` 测试，`Unit` 目录下包含的是**==单元测试==**类。
- `Feature/ExampleTest.php` —— 也包含一个 `testBasicExample()` 测试，用于测试访问应用首页返回状态码是否是 200，`Feature` 目录下包含的是**==功能测试==**类。

### 前端库

```json
    "devDependencies": {
        "@fortawesome/fontawesome-free": "^5.6.0",
        "@tailwindcss/forms": "^0.5.2",
        "alpinejs": "^3.4.2",
        "autoprefixer": "^10.4.2",
        "axios": "^1.6.4",
        "postcss": "^8.4.31",
        "tailwindcss": "^3.1.0",
        "laravel-mix": "^5.0.0",
        "datatables.net-bs4": "^1.10.19",
        "cross-env": "^5.1",
        "bootstrap": "^4.0.0",
        "clean-blog": "0.0.1-security",
        "jquery": "^3.2",
        "less": "^3.9.0",
        "less-loader": "^4.1.0",
        "lodash": "^4.17.5",
        "startbootstrap-clean-blog": "^5.0.1",
        "vue": "^2.5.17"
    }
```





## 2 快速搭建博客系统

### 1️⃣创建文章数据表及其模型

```sh
php artisan make:model -m Post
```

编辑相应迁移文件:

```php
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
```

数据库迁移:

```sh
php artisan migrate
```



### 2️⃣使用测试数据填充文章表

创建一个文章相应模型工厂文件：

```sh
php artisan make:factory PostFactory --model=Post
```

并编辑：

```php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(mt_rand(3, 10)),
            'content' => join("\n\n", fake()->paragraphs(mt_rand(3, 6))),
            'published_at' => fake()->dateTimeBetween('-1 month', '+3 days'),
        ];
    }
}
```



创建一个新的**填充类(Seeder)**文件并编辑:【Seeder会使用上面的模型工厂生成数据】

```sh
php artisan make:seeder PostsTableSeeder
```

```php
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(20)->create(); // 一次填充20篇文章
    }
}
```



在DatabaseSeeder.php中添加：

```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([PostsTableSeeder::class]);
    }
}
```



填充数据

```
php artisan db:seed
```



![](images/image-20240516134738858.png)

### 3️⃣创建配置文件

```php
<?php
return [
        'title' => 'My Blog',
        'posts_per_page' => 5
];
```

可通过`config('blog.title')`访问。

### 4️⃣创建路由和控制器



```sh
php artisan make:controller BlogController
```



### 5️⃣创建视图





## 3 后台管理系统

### 1️⃣创建路由

```php
// 后台路由
Route::get('/admin', function () {
    return redirect('/admin/post');
});
Route::middleware('auth')->group(function () {
    Route::resource('admin/post', PostController::class);
    Route::resource('admin/tag', TagController::class, ['except' => 'show']);
    Route::get('admin/upload', [UploadController::class, 'index']);
});
// 登录退出
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

```

### 2️⃣创建后台控制器

```sh
php artisan make:controller Admin/PostController --resource
php artisan make:controller Admin/TagController --resource
php artisan make:controller Admin/UploadController
```

### 3️⃣创建视图

```sh
npm run dev
```



#### 创建后台布局

`layout.blade.php`

- `<title>{{ config('blog.title') }} Admin</title>` ： 设置站点标题
- `@yield('styles')`：该 Blade 指令将会输出继承自该布局的子视图的 `styles` 区块内容（如果有的话），其目的在于将 CSS 样式文件放到模板顶部。
- `@include('admin.partials.navbar')`：这里我们引入另一个 Blade 模板（现在还不存在）
- `@yield('content')`：输出页面的主体内容
- `@yield('scripts')`：输出额外的 JavaScript 脚本文件

#### 创建导航条局部视图

`partials/navbar.blade.php`

```php
<ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link" href="/">首页</a></li>
    @auth
        <li @if (Request::is('admin/post*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/post">文章</a>
        </li>
        <li @if (Request::is('admin/tag*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/tag">标签</a>
        </li>
        <li @if (Request::is('admin/upload*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/upload">上传</a>
        </li>
    @endauth
</ul>

<ul class="navbar-nav ml-auto">
    @guest
        <li class="nav-item"><a class="nav-link" href="/login">登录</a></li>
    @else
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
               aria-expanded="false">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="/logout">退出</a>
            </div>
        </li>
    @endguest
</ul>
```

如果用户登录进来，该模板会显示一个顶部导航条：左侧包含「文章」、「标签」和「上传」链接，右侧包含「退出」链接。

如果用户没有登录，只在导航条右侧显示「登录」链接。

#### 创建登录表单



#### 创建错误局部视图

验证表单输入错误并在视图中显示这些错误在处理表单时是一个通用任务，所以我们将其放到一个单独的 Blade 模板视图中进行处理。

```php
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong>
        There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

`$errors` 变量在每个视图中都有效，其中包含了一个错误集合（如果有错误的话），我们只需要检查是否包含错误并将错误显示出来即可。

#### 创建文章列表视图









### 4️⃣测试登录/退出





#### 创建后台用户

`php artisan tinker` 可以用于通过命令行与应用进行交互:

```sh
$ php artisan tinker
Psy Shell v0.12.3 (PHP 8.3.6 — cli) by Justin Hileman
> use App\Models\User;
> $user = new User;
= App\Models\User {#5989}

> $user->name = 'andy';
= "andy"

> $user->email = 'rongming.2008@163.com';
= "rongming.2008@163.com"

> $user->password = bcrypt('123456');
= "$2y$12$S803Q0dmie0GUBqFGyVSK.3EThGYmcEKSPdAoA7s1rF7C4yalwDCi"

> $user-save();
= true
```





🔖



### 5️⃣引入 DataTables 和 FontAwesome

```sh
npm install datatables.net-bs4 --save-dev

npm install @fortawesome/fontawesome-free --save-dev
```



```scss
@import "bootstrap/scss/bootstrap";
@import "datatables.net-bs4/css/dataTables.bootstrap4";
@import "@fortawesome/fontawesome-free/scss/brands";
@import "@fortawesome/fontawesome-free/scss/regular";
@import "@fortawesome/fontawesome-free/scss/solid";
@import "@fortawesome/fontawesome-free/scss/fontawesome";
```







```sh
composer require laravel/breeze --dev
php artisan breeze:install
```











🔖   sass   DataTables



## 后台文件上传

默认存放在 `storage/app/public` 目录下



## 在后台实现文章增删改查功能（支持Markdown）

🔖





---

bug

- [ ] 文章列表页分页样式
- [ ] Auth  lar10新版本
