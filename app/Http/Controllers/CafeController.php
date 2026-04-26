<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Services\SawCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CafeController extends Controller
{
    public function __construct(
        private readonly SawCalculatorService $sawCalculator,
    ) {}

    /**
     * Display the ranking page with SAW calculation results.
     */
    public function index(): View
    {
        $cafes = Cafe::all();
        $result = $this->sawCalculator->calculate($cafes);

        return view('cafe.index', [
            'rankings' => $result['rankings'],
            'criteria' => $result['criteria'],
            'maxMin' => $result['max_min'],
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
