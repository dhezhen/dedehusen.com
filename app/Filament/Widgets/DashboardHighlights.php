<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Articles\ArticleResource;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\CourseMaterials\CourseMaterialResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\CourseMaterial;
use App\Models\Project;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class DashboardHighlights extends Widget
{
    protected static ?int $sort = 3;

    protected string $view = 'filament.widgets.dashboard-highlights';

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array{recentContent: Collection<int, array{type: string, title: string, status: string, updatedAt: mixed, url: string}>, recentMessages: Collection<int, ContactMessage>, articleUrl: string, articleCreateUrl: string, projectUrl: string, projectCreateUrl: string, materialUrl: string, materialCreateUrl: string, inboxUrl: string}
     */
    protected function getViewData(): array
    {
        $articles = Article::query()
            ->latest('updated_at')
            ->take(5)
            ->get(['id', 'title', 'is_published', 'published_at', 'updated_at'])
            ->map(fn (Article $article): array => [
                'type' => 'Artikel',
                'title' => $article->title,
                'status' => $article->publicationStatus(),
                'updatedAt' => $article->updated_at,
                'url' => ArticleResource::getUrl('edit', ['record' => $article]),
            ]);

        $projects = Project::query()
            ->latest('updated_at')
            ->take(5)
            ->get(['id', 'title', 'is_published', 'published_at', 'updated_at'])
            ->map(fn (Project $project): array => [
                'type' => 'Portofolio',
                'title' => $project->title,
                'status' => $project->publicationStatus(),
                'updatedAt' => $project->updated_at,
                'url' => ProjectResource::getUrl('edit', ['record' => $project]),
            ]);
        $materials = CourseMaterial::query()
            ->latest('updated_at')
            ->take(5)
            ->get(['id', 'title', 'is_published', 'published_at', 'updated_at'])
            ->map(fn (CourseMaterial $material): array => [
                'type' => 'Materi kuliah',
                'title' => $material->title,
                'status' => $material->publicationStatus(),
                'updatedAt' => $material->updated_at,
                'url' => CourseMaterialResource::getUrl('edit', ['record' => $material]),
            ]);

        return [
            'recentContent' => $articles
                ->concat($projects)
                ->concat($materials)
                ->sortByDesc('updatedAt')
                ->take(5)
                ->values(),
            'recentMessages' => ContactMessage::query()
                ->latest()
                ->take(5)
                ->get(['id', 'name', 'email', 'topic', 'read_at', 'created_at']),
            'articleUrl' => ArticleResource::getUrl(),
            'articleCreateUrl' => ArticleResource::getUrl('create'),
            'projectUrl' => ProjectResource::getUrl(),
            'projectCreateUrl' => ProjectResource::getUrl('create'),
            'materialUrl' => CourseMaterialResource::getUrl(),
            'materialCreateUrl' => CourseMaterialResource::getUrl('create'),
            'inboxUrl' => ContactMessageResource::getUrl(),
        ];
    }
}
