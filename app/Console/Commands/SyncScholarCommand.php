<?php

namespace App\Console\Commands;

use App\Services\ScholarService;
use Illuminate\Console\Command;

class SyncScholarCommand extends Command
{
    protected $signature = 'scholar:sync {scholar_id=euC8dCYAAAAJ : Google Scholar User ID}';

    protected $description = 'Sync Google Scholar profile citations and publication list';

    public function handle(ScholarService $scholarService): int
    {
        $scholarId = (string) $this->argument('scholar_id');

        $this->info("Memulai sinkronisasi Google Scholar untuk ID: {$scholarId}...");

        $result = $scholarService->sync($scholarId);

        if (! $result['success']) {
            $this->error($result['message']);

            return self::FAILURE;
        }

        $profile = $result['profile'];
        $this->info("Berhasil! {$result['message']}");
        $this->table(
            ['Metrik', 'Semua Waktu', 'Sejak 5 Tahun'],
            [
                ['Total Sitasi', $profile->citations_all, $profile->citations_since],
                ['h-index', $profile->h_index_all, $profile->h_index_since],
                ['i10-index', $profile->i10_index_all, $profile->i10_index_since],
                ['Jumlah Artikel Disinkronkan', $result['count'], '-'],
            ]
        );

        return self::SUCCESS;
    }
}
