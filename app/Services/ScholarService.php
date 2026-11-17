<?php

namespace App\Services;

use App\Models\ScholarProfile;
use App\Models\ScholarPublication;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Log;

class ScholarService
{
    public const DEFAULT_SCHOLAR_ID = 'euC8dCYAAAAJ';

    public function sync(string $scholarId = self::DEFAULT_SCHOLAR_ID): array
    {
        $html = $this->fetchHtml($scholarId);

        if (! $html) {
            Log::warning("ScholarService: Failed to fetch Google Scholar profile for ID {$scholarId}");

            return [
                'success' => false,
                'message' => 'Gagal mengambil data dari Google Scholar. Cek koneksi internet atau proteksi akses.',
            ];
        }

        $parsed = $this->parseHtml($html);

        if (empty($parsed['articles']) && $parsed['stats']['citations_all'] === 0) {
            Log::warning("ScholarService: Empty data parsed for ID {$scholarId}");

            return [
                'success' => false,
                'message' => 'Data tidak ditemukan atau struktur halaman Google Scholar berubah.',
            ];
        }

        $profile = ScholarProfile::updateOrCreate(
            ['scholar_id' => $scholarId],
            [
                'author_name' => $parsed['author_name'],
                'affiliation' => $parsed['affiliation'],
                'citations_all' => $parsed['stats']['citations_all'],
                'citations_since' => $parsed['stats']['citations_since'],
                'h_index_all' => $parsed['stats']['h_index_all'],
                'h_index_since' => $parsed['stats']['h_index_since'],
                'i10_index_all' => $parsed['stats']['i10_index_all'],
                'i10_index_since' => $parsed['stats']['i10_index_since'],
                'citation_history' => $parsed['citation_history'],
                'last_synced_at' => now(),
            ]
        );

        $syncedTitles = [];
        foreach ($parsed['articles'] as $item) {
            $syncedTitles[] = $item['title'];
            ScholarPublication::updateOrCreate(
                [
                    'scholar_profile_id' => $profile->id,
                    'title' => $item['title'],
                ],
                [
                    'authors' => $item['authors'],
                    'venue' => $item['venue'],
                    'year' => $item['year'],
                    'citations' => $item['citations'],
                    'scholar_citation_url' => $item['link'],
                    'is_visible' => true,
                ]
            );
        }

        return [
            'success' => true,
            'message' => 'Profil Google Scholar berhasil disinkronkan.',
            'profile' => $profile,
            'count' => count($parsed['articles']),
        ];
    }

    protected function fetchHtml(string $scholarId): ?string
    {
        $url = 'https://scholar.google.com/citations?hl=id&user='.urlencode($scholarId).'&pagesize=100';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error || $httpCode !== 200 || ! $response) {
            Log::error("ScholarService cURL error: code={$httpCode}, err={$error}");

            return null;
        }

        return $response;
    }

    public function parseHtml(string $html): array
    {
        $doc = new DOMDocument();
        @$doc->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        $xpath = new DOMXPath($doc);

        // Author Name
        $nameNodes = $xpath->query('//div[@id="gsc_prf_in"]');
        $authorName = $nameNodes->length > 0 ? preg_replace('/\s+/', ' ', trim($nameNodes->item(0)->textContent)) : '';

        // Affiliation
        $affNodes = $xpath->query('//div[@class="gsc_prf_il"]');
        $affiliation = $affNodes->length > 0 ? trim($affNodes->item(0)->textContent) : '';

        // Stats table: #gsc_rsb_st
        $stats = [
            'citations_all' => 0,
            'citations_since' => 0,
            'h_index_all' => 0,
            'h_index_since' => 0,
            'i10_index_all' => 0,
            'i10_index_since' => 0,
        ];

        $statRows = $xpath->query('//table[@id="gsc_rsb_st"]//tbody//tr');
        foreach ($statRows as $row) {
            $cells = $xpath->query('td', $row);
            if ($cells->length >= 3) {
                $metric = strtolower(trim($cells->item(0)->textContent));
                $all = (int) trim($cells->item(1)->textContent);
                $since = (int) trim($cells->item(2)->textContent);

                if (str_contains($metric, 'kutipan') || str_contains($metric, 'citation')) {
                    $stats['citations_all'] = $all;
                    $stats['citations_since'] = $since;
                } elseif (str_contains($metric, 'indeks-h') || str_contains($metric, 'h-index')) {
                    $stats['h_index_all'] = $all;
                    $stats['h_index_since'] = $since;
                } elseif (str_contains($metric, 'indeks-i10') || str_contains($metric, 'i10-index')) {
                    $stats['i10_index_all'] = $all;
                    $stats['i10_index_since'] = $since;
                }
            }
        }

        // Citation history per year
        $yearNodes = $xpath->query('//span[@class="gsc_g_t"]');
        $countNodes = $xpath->query('//span[@class="gsc_g_al"]');
        $citationHistory = [];
        for ($i = 0; $i < $yearNodes->length; $i++) {
            $year = trim($yearNodes->item($i)->textContent);
            $count = $countNodes->item($i) ? (int) trim($countNodes->item($i)->textContent) : 0;
            if ($year !== '') {
                $citationHistory[$year] = $count;
            }
        }

        // Articles
        $articles = [];
        $rows = $xpath->query('//tr[@class="gsc_a_tr"]');
        foreach ($rows as $row) {
            $titleNode = $xpath->query('.//td[@class="gsc_a_t"]/a', $row);
            $metaNodes = $xpath->query('.//td[@class="gsc_a_t"]/div[@class="gs_gray"]', $row);
            $citeNode = $xpath->query('.//td[@class="gsc_a_c"]/a', $row);
            $yearNode = $xpath->query('.//td[@class="gsc_a_y"]/span', $row);

            $title = $titleNode->length > 0 ? trim($titleNode->item(0)->textContent) : '';
            $rawLink = $titleNode->length > 0 ? $titleNode->item(0)->getAttribute('href') : '';
            $link = $rawLink !== '' ? (str_starts_with($rawLink, 'http') ? $rawLink : 'https://scholar.google.com'.$rawLink) : '';

            $authors = $metaNodes->length > 0 ? trim($metaNodes->item(0)->textContent) : '';
            $venue = $metaNodes->length > 1 ? trim($metaNodes->item(1)->textContent) : '';
            $citations = $citeNode->length > 0 && trim($citeNode->item(0)->textContent) !== '' ? (int) trim($citeNode->item(0)->textContent) : 0;
            $year = $yearNode->length > 0 ? trim($yearNode->item(0)->textContent) : null;

            if ($title !== '') {
                $articles[] = [
                    'title' => $title,
                    'link' => $link,
                    'authors' => $authors,
                    'venue' => $venue,
                    'citations' => $citations,
                    'year' => $year,
                ];
            }
        }

        return [
            'author_name' => $authorName,
            'affiliation' => $affiliation,
            'stats' => $stats,
            'citation_history' => $citationHistory,
            'articles' => $articles,
        ];
    }
}
