<x-filament-widgets::widget class="fi-wi-chart">
    <x-filament::section :heading="$heading" :description="$description">
        <figure class="dashboard-visits-figure" aria-labelledby="visits-chart-caption">
            <svg class="dashboard-visits-svg" viewBox="0 0 900 170" preserveAspectRatio="none" role="img" aria-labelledby="visits-chart-title visits-chart-description">
                <title id="visits-chart-title">{{ $heading }}</title>
                <desc id="visits-chart-description">{{ $description }}</desc>

                <g class="dashboard-visits-grid" aria-hidden="true">
                    @foreach ($gridLines as $line)
                        <line x1="52" x2="860" y1="{{ $line['y'] }}" y2="{{ $line['y'] }}"></line>
                        <text x="42" y="{{ $line['y'] + 4 }}" text-anchor="end">{{ $line['value'] }}</text>
                    @endforeach
                </g>

                <polyline class="dashboard-visits-line" points="{{ $path }}"></polyline>

                <g class="dashboard-visits-points" aria-hidden="true">
                    @foreach ($points as $point)
                        @if ($point['value'] > 0)
                            <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="3.5"></circle>
                        @endif
                    @endforeach
                </g>

                @if ($latestActivePoint)
                    <text class="dashboard-visits-value-label" x="{{ $latestActivePoint['x'] }}" y="{{ max($latestActivePoint['y'] - 12, 12) }}" text-anchor="middle">{{ $latestActivePoint['value'] }}</text>
                @endif

                <g class="dashboard-visits-labels" aria-hidden="true">
                    @foreach ($ticks as $tick)
                        <text x="{{ $tick['x'] }}" y="158" text-anchor="middle">{{ $tick['label'] }}</text>
                    @endforeach
                </g>
            </svg>

            <figcaption id="visits-chart-caption" class="dashboard-visits-caption">
                @foreach ($points as $point)
                    <span>{{ $point['label'] }}: {{ $point['value'] }} kunjungan.</span>
                @endforeach
            </figcaption>
        </figure>
    </x-filament::section>
</x-filament-widgets::widget>
