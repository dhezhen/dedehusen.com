<x-filament-widgets::widget>
    <x-filament::section class="dashboard-highlights-surface">
        <x-slot name="heading">Pembaruan terbaru</x-slot>
        <x-slot name="description">Konten yang terakhir diperbarui dan pesan yang masuk.</x-slot>

        <div class="dashboard-highlights-grid">
            <section class="dashboard-highlights-column" aria-labelledby="dashboard-content-heading">
                <div class="dashboard-highlights-heading">
                    <h3 id="dashboard-content-heading">Konten terbaru</h3>
                    <div class="dashboard-highlights-actions">
                        <a href="{{ $articleUrl }}">Artikel</a>
                        <a href="{{ $projectUrl }}">Portofolio</a>
                        <a href="{{ $materialUrl }}">Materi kuliah</a>
                    </div>
                </div>

                @if ($recentContent->isEmpty())
                    <div class="dashboard-highlights-empty">
                        <p>Belum ada konten. Tambahkan artikel, portofolio, atau materi kuliah dari sini.</p>
                        <div class="dashboard-highlights-actions">
                            <a href="{{ $articleCreateUrl }}">Tambah artikel</a>
                            <a href="{{ $projectCreateUrl }}">Tambah proyek</a>
                            <a href="{{ $materialCreateUrl }}">Tambah materi</a>
                        </div>
                    </div>
                @else
                    <ul class="dashboard-highlights-list">
                        @foreach ($recentContent as $item)
                            <li>
                                <a href="{{ $item['url'] }}" class="dashboard-highlights-link">
                                    <span class="dashboard-highlights-link-copy">
                                        <span class="dashboard-highlights-meta">{{ $item['type'] }} / {{ $item['status'] }}</span>
                                        <span class="dashboard-highlights-title">{{ $item['title'] }}</span>
                                    </span>
                                    <time class="dashboard-highlights-time" datetime="{{ $item['updatedAt']?->toIso8601String() }}">{{ $item['updatedAt']?->diffForHumans() }}</time>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <section class="dashboard-highlights-column" aria-labelledby="dashboard-inbox-heading">
                <div class="dashboard-highlights-heading">
                    <h3 id="dashboard-inbox-heading">Pesan masuk</h3>
                    <a href="{{ $inboxUrl }}">Buka inbox</a>
                </div>

                @if ($recentMessages->isEmpty())
                    <p class="dashboard-highlights-empty">Belum ada pesan masuk dari formulir kontak.</p>
                @else
                    <ul class="dashboard-highlights-list">
                        @foreach ($recentMessages as $message)
                            <li>
                                <a href="{{ \App\Filament\Resources\ContactMessages\ContactMessageResource::getUrl('edit', ['record' => $message]) }}" class="dashboard-highlights-link dashboard-highlights-message">
                                    <span class="dashboard-highlights-link-copy">
                                        <span class="dashboard-highlights-title">{{ $message->name }}</span>
                                        <span class="dashboard-highlights-meta">{{ $message->topic ?: $message->email }}</span>
                                    </span>
                                    <span class="dashboard-highlights-message-status {{ $message->read_at ? 'is-read' : 'is-unread' }}">{{ $message->read_at ? 'Sudah dibaca' : 'Belum dibaca' }}</span>
                                    <time class="dashboard-highlights-time" datetime="{{ $message->created_at?->toIso8601String() }}">{{ $message->created_at?->diffForHumans() }}</time>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
