<?php

namespace App\Http\Controllers;

use App\Enums\ArticleCategory;
use App\Models\Article;
use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'projects' => Project::query()
                ->select(['id', 'title', 'slug', 'category', 'summary', 'thumbnail', 'published_at'])
                ->published()
                ->latest('published_at')
                ->take(3)
                ->get(),
            'articles' => collect(ArticleCategory::cases())
                ->flatMap(fn (ArticleCategory $category) => Article::query()
                    ->select(['id', 'title', 'slug', 'category', 'excerpt', 'thumbnail', 'thumbnail_alt', 'published_at'])
                    ->where('category', $category->value)
                    ->published()
                    ->latest('published_at')
                    ->latest('id')
                    ->take(3)
                    ->get())
                ->sort(fn (Article $left, Article $right): int => $right->published_at->getTimestamp() <=> $left->published_at->getTimestamp() ?: $right->id <=> $left->id)
                ->values(),
        ]);
    }
}
