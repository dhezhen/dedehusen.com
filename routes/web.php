<?php

use App\Enums\ArticleCategory;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicationController;
use App\Http\Middleware\TrackPageVisit;
use App\Models\Article;
use App\Models\Course;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(TrackPageVisit::class)->group(function (): void {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/articles', function (Request $request) {
        $requestedCategory = $request->query('category');
        $categories = ArticleCategory::options();
        $category = is_string($requestedCategory) && array_key_exists($requestedCategory, $categories)
            ? $requestedCategory
            : null;

        $query = Article::query()
            ->select(['id', 'title', 'slug', 'category', 'excerpt', 'thumbnail', 'thumbnail_alt', 'published_at'])
            ->published()
            ->latest('published_at')
            ->latest('id');

        if ($category !== null) {
            $query->where('category', $category);
        }

        return view('articles.index', [
            'articles' => $query->paginate(12)->withQueryString(),
            'categories' => $categories,
            'activeCategory' => $category,
        ]);
    })->name('articles.index');
    Route::get('/courses', function () {
        $courses = Course::query()
            ->with(['materials' => fn ($query) => $query->published()->orderBy('sort_order')->orderBy('title')])
            ->whereHas('materials', fn ($query) => $query->published())
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('static.bahan-kuliah', compact('courses'));
    })->name('courses.index');
    Route::view('/education', 'static.pendidikan')->name('education.index');
    Route::view('/research', 'static.penelitian')->name('research.index');
    Route::view('/community-service', 'static.pengabdian')->name('community-service.index');
    Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
    Route::post('/publications/sync', [PublicationController::class, 'sync'])->middleware('throttle:5,60')->name('publications.sync');
    Route::get('/portfolio', fn () => view('portfolio.index', [
        'projects' => Project::query()
            ->select(['id', 'title', 'slug', 'category', 'summary', 'thumbnail', 'thumbnail_alt', 'source_url', 'published_at', 'sort_order'])
            ->published()
            ->orderBy('sort_order')
            ->latest('published_at')
            ->get(),
    ]))->name('portfolio.index');
    Route::get('/portfolio/{slug}', fn (string $slug) => view('portfolio.show', ['project' => Project::published()->where('slug', $slug)->firstOrFail()]))->name('portfolio.show');
    Route::get('/articles/{slug}', function (string $slug) {
        $article = Article::published()->where('slug', $slug)->firstOrFail();
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->select(['id', 'title', 'slug', 'category', 'excerpt', 'thumbnail', 'thumbnail_alt', 'published_at'])
            ->latest('published_at')
            ->limit(3)
            ->get();
        $prevArticle = Article::published()
            ->where('published_at', '<', $article->published_at)
            ->select(['id', 'title', 'slug', 'published_at'])
            ->latest('published_at')
            ->first();
        $nextArticle = Article::published()
            ->where('published_at', '>', $article->published_at)
            ->select(['id', 'title', 'slug', 'published_at'])
            ->oldest('published_at')
            ->first();

        return view('articles.show', compact('article', 'relatedArticles', 'prevArticle', 'nextArticle'));
    })->name('articles.show');
});

Route::post('/contact', ContactMessageController::class)->middleware('throttle:contact')->name('contact.store');
Route::redirect('/index.html', '/', 301);
Route::redirect('/artikel.html', '/articles', 301);
Route::redirect('/bahan-kuliah.html', '/courses', 301);
Route::redirect('/pendidikan.html', '/education', 301);
Route::redirect('/penelitian.html', '/research', 301);
Route::redirect('/pengabdian.html', '/community-service', 301);
Route::redirect('/publikasi.html', '/publications', 301);
Route::redirect('/portofolio.html', '/portfolio', 301);
