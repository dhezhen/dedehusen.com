<?php

namespace App\Filament\Widgets;

use App\Models\Visit;
use Carbon\CarbonPeriod;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class VisitsChart extends Widget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.visits-chart';

    protected function getViewData(): array
    {
        $today = Carbon::today();
        $start = $today->copy()->subDays(29);
        $end = $today->copy()->addDay();
        $counts = Visit::query()
            ->where('created_at', '>=', $start)
            ->where('created_at', '<', $end)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');
        $days = collect(CarbonPeriod::create($start, Carbon::today()));
        $highestCount = (int) $counts->max();
        $axisMaximum = max((int) (ceil($highestCount * 1.2 / 10) * 10), 10);
        $lastIndex = max($days->count() - 1, 1);
        $points = $days->values()->map(function (Carbon $day, int $index) use ($counts, $axisMaximum, $lastIndex): array {
            $value = (int) ($counts[$day->toDateString()] ?? 0);

            return [
                'x' => round(52 + (808 * $index / $lastIndex), 1),
                'y' => round(20 + (108 * (1 - ($value / $axisMaximum))), 1),
                'value' => $value,
                'label' => $day->format('d M'),
            ];
        });
        $tickIndices = [0, 7, 14, 21, $lastIndex];

        return [
            'points' => $points,
            'path' => $points->map(fn (array $point): string => $point['x'].','.$point['y'])->implode(' '),
            'ticks' => $points->filter(fn (array $point, int $index): bool => in_array($index, $tickIndices, true))->values(),
            'latestActivePoint' => $points->filter(fn (array $point): bool => $point['value'] > 0)->last(),
            'gridLines' => [
                ['y' => 20, 'value' => $axisMaximum],
                ['y' => 74, 'value' => (int) round($axisMaximum / 2)],
                ['y' => 128, 'value' => 0],
            ],
            'heading' => 'Kunjungan tercatat untuk 30 hari terakhir',
            'description' => 'Jumlah catatan kunjungan harian dari seluruh halaman publik.',
        ];
    }
}
