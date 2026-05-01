<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Services\SawCalculatorService;
use App\Services\SmartCalculatorService;
use App\Services\WpCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CafeController extends Controller
{
    public function __construct(
        private readonly SawCalculatorService $sawCalculator,
        private readonly WpCalculatorService $wpCalculator,
        private readonly SmartCalculatorService $smartCalculator,
    ) {}

    /**
     * Display the ranking page with calculation results.
     */
    public function index(): View
    {
        $cafes = Cafe::all();
        $sawResult = $this->sawCalculator->calculate($cafes);
        $wpResult = $this->wpCalculator->calculate($cafes);
        $smartResult = $this->smartCalculator->calculate($cafes);

        $comparison = [];
        foreach ($sawResult['rankings'] as $sawItem) {
            $cafeId = $sawItem['cafe']->id;
            $comparison[$cafeId] = [
                'cafe' => $sawItem['cafe'],
                'saw_rank' => $sawItem['rank'],
                'saw_value' => $sawItem['nilai_akhir'],
                'wp_rank' => 0,
                'wp_value' => 0.0,
                'smart_rank' => 0,
                'smart_value' => 0.0,
            ];
        }

        foreach ($wpResult['rankings'] as $wpItem) {
            $cafeId = $wpItem['cafe']->id;
            if (isset($comparison[$cafeId])) {
                $comparison[$cafeId]['wp_rank'] = $wpItem['rank'];
                $comparison[$cafeId]['wp_value'] = $wpItem['nilai_akhir'];
            }
        }

        foreach ($smartResult['rankings'] as $smartItem) {
            $cafeId = $smartItem['cafe']->id;
            if (isset($comparison[$cafeId])) {
                $comparison[$cafeId]['smart_rank'] = $smartItem['rank'];
                $comparison[$cafeId]['smart_value'] = $smartItem['nilai_akhir'];
            }
        }

        // Hitung Konsensus
        $bestConsensus = null;
        $bestAvgRank = 9999;
        
        foreach ($comparison as &$item) {
            $avgRank = ($item['saw_rank'] + $item['wp_rank'] + $item['smart_rank']) / 3;
            $item['avg_rank'] = $avgRank;
            
            if ($avgRank < $bestAvgRank) {
                $bestAvgRank = $avgRank;
                $bestConsensus = $item;
            }
        }
        unset($item);

        usort($comparison, fn($a, $b) => $a['saw_rank'] <=> $b['saw_rank']);

        return view('cafe.index', [
            'rankings' => $sawResult['rankings'],
            'wpRankings' => $wpResult['rankings'],
            'smartRankings' => $smartResult['rankings'],
            'comparison' => $comparison,
            'bestConsensus' => $bestConsensus,
            'criteria' => $sawResult['criteria'],
            'maxMin' => $sawResult['max_min'],
            'smartMaxMin' => $smartResult['max_min'],
            'totalCafes' => $cafes->count(),
        ]);
    }

    /**
     * Show the form for creating a new cafe.
     */
    public function create(): View
    {
        $criteria = $this->sawCalculator->getCriteriaLabels();

        return view('cafe.create', compact('criteria'));
    }

    /**
     * Store a newly created cafe in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_cafe' => ['required', 'string', 'max:255'],
            'wifi_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'harga_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'bangunan_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'luas_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'jarak_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
        ]);

        Cafe::create($validated);

        return redirect()->route('cafe.index')
            ->with('success', 'Data cafe berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified cafe.
     */
    public function edit(Cafe $cafe): View
    {
        $criteria = $this->sawCalculator->getCriteriaLabels();

        return view('cafe.edit', compact('cafe', 'criteria'));
    }

    /**
     * Update the specified cafe in storage.
     */
    public function update(Request $request, Cafe $cafe): RedirectResponse
    {
        $validated = $request->validate([
            'nama_cafe' => ['required', 'string', 'max:255'],
            'wifi_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'harga_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'bangunan_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'luas_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
            'jarak_score' => ['required', 'numeric', 'min:0.2', 'max:1'],
        ]);

        $cafe->update($validated);

        return redirect()->route('cafe.index')
            ->with('success', 'Data cafe berhasil diperbarui!');
    }

    /**
     * Remove the specified cafe from storage.
     */
    public function destroy(Cafe $cafe): RedirectResponse
    {
        $cafe->delete();

        return redirect()->route('cafe.index')
            ->with('success', 'Data cafe berhasil dihapus!');
    }
}
