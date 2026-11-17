<?php

namespace App\Http\Controllers;

use App\Models\ScholarProfile;
use App\Models\ScholarPublication;
use App\Services\ScholarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicationController extends Controller
{
    public function index(Request $request): View
    {
        $profile = ScholarProfile::where('scholar_id', ScholarService::DEFAULT_SCHOLAR_ID)->first();

        $sort   = $request->query('sort', 'year');
        $year   = $request->query('year', '');
        $search = trim((string) $request->query('q', ''));

        // Distinct years for filter pills
        $availableYears = ScholarPublication::visible()
            ->selectRaw("year")
            ->distinct()
            ->orderByRaw("CAST(year AS INTEGER) DESC")
            ->pluck('year')
            ->filter()
            ->values();

        $query = ScholarPublication::query()->visible();

        // --- Search ---
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('authors', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        // --- Year filter ---
        if ($year !== '') {
            $query->where('year', $year);
        }

        // --- Sort ---
        if ($sort === 'citations') {
            $query->orderByDesc('citations')->orderByDesc('year');
        } else {
            $query->orderByRaw("CASE WHEN year IS NULL OR year = '' THEN 0 ELSE CAST(year AS INTEGER) END DESC")
                  ->orderByDesc('citations');
        }

        $publications   = $query->get();
        $totalFiltered  = $publications->count();
        $totalAll       = ScholarPublication::visible()->count();

        return view('static.publikasi', [
            'profile'         => $profile,
            'publications'    => $publications,
            'sort'            => $sort,
            'year'            => $year,
            'search'          => $search,
            'availableYears'  => $availableYears,
            'totalFiltered'   => $totalFiltered,
            'totalPublications' => $totalAll,
        ]);
    }

    public function sync(ScholarService $scholarService): RedirectResponse
    {
        $result = $scholarService->sync(ScholarService::DEFAULT_SCHOLAR_ID);

        if ($result['success']) {
            return redirect()->route('publications.index')
                ->with('status', 'Data Google Scholar berhasil diperbarui!');
        }

        return redirect()->route('publications.index')
            ->with('error', $result['message']);
    }
}
