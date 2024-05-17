<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('blog.title') }}</title>
    <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed {{ config('blog.title') }}">

    {{-- Styles --}}
    @vite('resources/sass/app.scss')

    @yield('styles')
</head>
<body>
@include('blog.partials.page-nav')

@yield('page-header')

@yield('content')

@include('blog.partials.page-footer')

{{-- Scripts --}}
@yield('scripts')
</body>
</html>
