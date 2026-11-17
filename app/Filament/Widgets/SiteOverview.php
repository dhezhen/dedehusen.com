<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\CourseMaterial;
use App\Models\Project;
use App\Models\Visit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Ringkasan situs';

    protected ?string $description = 'Status kunjungan, konten, dan pesan masuk.';

    protected int|array|null $columns = [
        '@md' => 2,
        '@xl' => 4,
        '!@md' => 1,
        '!@xl' => 2,
    ];

    protected function getStats(): array
    {
        $today = today();
        $tomorrow = $today->copy()->addDay();
        $tomorrowDate = $tomorrow->toDateString();
        $currentWeekStart = $today->copy()->subDays(6);
        $previousWeekStart = $currentWeekStart->copy()->subDays(7);
        $date = $today->toDateString();
        $dailyVisits = Visit::query()
            ->where('created_at', '>=', $previousWeekStart)
            ->where('created_at', '<', $tomorrow)
            ->selectRaw('DATE(created_at) as visit_date, COUNT(*) as page_views, COUNT(DISTINCT visitor_hash) as unique_visitors')
            ->groupBy('visit_date')
            ->get()
            ->keyBy('visit_date');
        $todayVisits = $dailyVisits->get($date);
        $currentWeekVisits = (int) $dailyVisits
            ->filter(fn (Visit $visit): bool => $visit->visit_date >= $currentWeekStart->toDateString())
            ->sum('page_views');
        $previousWeekVisits = (int) $dailyVisits
            ->filter(fn (Visit $visit): bool => $visit->visit_date < $currentWeekStart->toDateString())
            ->sum('page_views');
        $weeklyChange = $previousWeekVisits > 0
            ? (int) round((($currentWeekVisits - $previousWeekVisits) / $previousWeekVisits) * 100)
            : null;
        $topPage = Visit::query()
            ->where('created_at', '>=', $currentWeekStart)
            ->where('created_at', '<', $tomorrow)
            ->select('path')
            ->selectRaw('COUNT(*) as page_views')
            ->groupBy('path')
            ->orderByDesc('page_views')
            ->orderBy('path')
            ->first();
        $messageCounts = ContactMessage::query()
            ->selectRaw('SUM(CASE WHEN read_at IS NULL THEN 1 ELSE 0 END) as unread_count')
            ->selectRaw('SUM(CASE WHEN created_at >= ? AND created_at < ? THEN 1 ELSE 0 END) as recent_count', [$currentWeekStart, $tomorrow])
            ->first();
        $articleCounts = $this->publicationCounts(Article::class, $tomorrowDate);
        $projectCounts = $this->publicationCounts(Project::class, $tomorrowDate);
        $materialCounts = $this->publicationCounts(CourseMaterial::class, $tomorrowDate);
        $comparisonDescription = $weeklyChange === null
            ? 'Belum ada data untuk dibandingkan.'
            : sprintf('%s%d%% dibanding 7 hari sebelumnya', $weeklyChange > 0 ? '+' : '', $weeklyChange);

        return [
            Stat::make('Kunjungan halaman hari ini', (int) ($todayVisits?->page_views ?? 0))
                ->description('Alamat IP yang sama dihitung sekali per halaman per hari.'),
            Stat::make('Pengunjung hari ini · estimasi', (int) ($todayVisits?->unique_visitors ?? 0))
                ->description('Diperkirakan dari alamat IP, bukan identitas orang.'),
            Stat::make('Kunjungan halaman · 7 hari', $currentWeekVisits)
                ->description($comparisonDescription)
                ->color($weeklyChange === null ? 'gray' : ($weeklyChange >= 0 ? 'success' : 'danger')),
            Stat::make('Kunjungan rute teratas · 7 hari', (int) ($topPage?->page_views ?? 0))
                ->description($topPage?->path ?? 'Belum ada kunjungan pada periode ini.'),
            Stat::make('Artikel terbit', $articleCounts['published'])
                ->description($articleCounts['drafts'].' draf · '.$articleCounts['scheduled'].' terjadwal'),
            Stat::make('Proyek terbit', $projectCounts['published'])
                ->description($projectCounts['drafts'].' draf · '.$projectCounts['scheduled'].' terjadwal'),
            Stat::make('Materi terbit', $materialCounts['published'])
                ->description($materialCounts['drafts'].' draf · '.$materialCounts['scheduled'].' terjadwal'),
            Stat::make('Pesan belum dibaca', (int) ($messageCounts?->unread_count ?? 0))
                ->description((int) ($messageCounts?->recent_count ?? 0).' pesan masuk dalam 7 hari terakhir.'),
        ];
    }

    /**
     * @param  class-string  $model
     * @return array{published: int, drafts: int, scheduled: int}
     */
    private function publicationCounts(string $model, string $tomorrow): array
    {
        $counts = $model::query()
            ->selectRaw('SUM(CASE WHEN is_published = 1 AND published_at IS NOT NULL AND published_at < ? THEN 1 ELSE 0 END) as published_count', [$tomorrow])
            ->selectRaw('SUM(CASE WHEN is_published = 0 OR published_at IS NULL THEN 1 ELSE 0 END) as draft_count')
            ->selectRaw('SUM(CASE WHEN is_published = 1 AND published_at >= ? THEN 1 ELSE 0 END) as scheduled_count', [$tomorrow])
            ->first();

        return [
            'published' => (int) ($counts?->published_count ?? 0),
            'drafts' => (int) ($counts?->draft_count ?? 0),
            'scheduled' => (int) ($counts?->scheduled_count ?? 0),
        ];
    }
}
