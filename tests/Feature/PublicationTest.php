<?php

namespace Tests\Feature;

use App\Models\ScholarProfile;
use App\Models\ScholarPublication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    use RefreshDatabase;

    private ScholarProfile $profile;

    protected function setUp(): void
    {
        parent::setUp();

        $this->profile = ScholarProfile::create([
            'scholar_id'       => 'euC8dCYAAAAJ',
            'author_name'      => 'Dede Husen',
            'affiliation'      => 'Universitas Kuningan',
            'citations_all'    => 91,
            'citations_since'  => 91,
            'h_index_all'      => 5,
            'h_index_since'    => 5,
            'i10_index_all'    => 4,
            'i10_index_since'  => 4,
            'citation_history' => ['2024' => 10, '2025' => 28, '2026' => 45],
            'last_synced_at'   => now(),
        ]);

        ScholarPublication::create([
            'scholar_profile_id' => $this->profile->id,
            'title'              => 'Evaluasi Teknik Augmentasi Data CNN Citra MRI',
            'authors'            => 'D Husen',
            'venue'              => 'Jurnal Teknologi dan Informasi',
            'year'               => '2024',
            'citations'          => 20,
            'scholar_citation_url' => 'https://scholar.google.com/test1',
            'is_visible'         => true,
        ]);

        ScholarPublication::create([
            'scholar_profile_id' => $this->profile->id,
            'title'              => 'Peningkatan Literasi Digital Smart Village',
            'authors'            => 'D Husen',
            'venue'              => 'Jurnal Pengabdian Masyarakat',
            'year'               => '2025',
            'citations'          => 19,
            'scholar_citation_url' => 'https://scholar.google.com/test2',
            'is_visible'         => true,
        ]);
    }

    public function test_publications_page_renders_successfully(): void
    {
        $response = $this->get('/publications');

        $response->assertStatus(200);
        $response->assertSee('Publikasi Ilmiah');
        $response->assertSee('Total Sitasi');
        $response->assertSee('91');
        $response->assertSee('h-index');
        $response->assertSee('i10-index');
    }

    public function test_publications_page_shows_publications_list(): void
    {
        $response = $this->get('/publications');

        $response->assertSee('Evaluasi Teknik Augmentasi Data');
        $response->assertSee('Peningkatan Literasi Digital');
    }

    public function test_search_filters_by_title(): void
    {
        $response = $this->get('/publications?q=Augmentasi');

        $response->assertStatus(200);
        $response->assertSee('Evaluasi Teknik Augmentasi Data');
        $response->assertDontSee('Peningkatan Literasi Digital');
    }

    public function test_search_filters_by_venue(): void
    {
        $response = $this->get('/publications?q=Pengabdian');

        $response->assertStatus(200);
        $response->assertSee('Peningkatan Literasi Digital');
        $response->assertDontSee('Evaluasi Teknik Augmentasi Data');
    }

    public function test_year_filter_shows_only_matching_year(): void
    {
        $response = $this->get('/publications?year=2024');

        $response->assertStatus(200);
        $response->assertSee('Evaluasi Teknik Augmentasi Data');
        $response->assertDontSee('Peningkatan Literasi Digital');
    }

    public function test_combined_search_and_year_filter(): void
    {
        $response = $this->get('/publications?q=Literasi&year=2025');

        $response->assertStatus(200);
        $response->assertSee('Peningkatan Literasi Digital');
        $response->assertDontSee('Evaluasi Teknik Augmentasi Data');
    }

    public function test_sort_by_citations(): void
    {
        $response = $this->get('/publications?sort=citations');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Evaluasi Teknik Augmentasi Data', 'Peningkatan Literasi Digital']);
    }

    public function test_empty_search_shows_empty_state(): void
    {
        $response = $this->get('/publications?q=tidakadahasilnya');

        $response->assertStatus(200);
        $response->assertSee('Tidak ada publikasi yang cocok');
    }

    public function test_year_pills_appear_in_filter(): void
    {
        $response = $this->get('/publications');

        $response->assertStatus(200);
        $response->assertSee('2024');
        $response->assertSee('2025');
        $response->assertSee('Semua');
    }
}
