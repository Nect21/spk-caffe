<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class SawCalculatorService
{
    /**
     * Criteria configuration: column => [weight, type]
     * Benefit: higher is better → rij = xij / max(xij)
     * Cost:    lower is better  → rij = min(xij) / xij
     */
    private const array CRITERIA = [
        'wifi_score'     => ['weight' => 0.30, 'type' => 'benefit'],
        'harga_score'    => ['weight' => 0.25, 'type' => 'cost'],
        'bangunan_score' => ['weight' => 0.17, 'type' => 'cost'],
        'luas_score'     => ['weight' => 0.15, 'type' => 'benefit'],
        'jarak_score'    => ['weight' => 0.13, 'type' => 'benefit'],
    ];

    /**
     * Calculate SAW rankings for a collection of cafes.
     *
     * @param  Collection  $cafes  Collection of Cafe models
     * @return array{
     *     rankings: array<int, array{
     *         cafe: \App\Models\Cafe,
     *         normalized: array<string, float>,
     *         nilai_akhir: float,
     *         predikat: string,
     *         rank: int
     *     }>,
     *     criteria: array<string, array{weight: float, type: string, label: string}>,
     *     max_min: array<string, array{max: float, min: float}>
     * }
     */
    public function calculate(Collection $cafes): array
    {
        if ($cafes->isEmpty()) {
            return [
                'rankings' => [],
                'criteria' => $this->getCriteriaLabels(),
                'max_min' => [],
            ];
        }

        // Step 1: Find max and min for each criterion
        $maxMin = [];
        foreach (self::CRITERIA as $column => $config) {
            $values = $cafes->pluck($column)->filter(fn ($v) => $v > 0);
            $maxMin[$column] = [
                'max' => $values->max() ?: 1.0,
                'min' => $values->min() ?: 0.2,
            ];
        }

        // Step 2: Normalize and calculate Vi for each cafe
        $results = [];
        foreach ($cafes as $cafe) {
            $normalized = [];
            $vi = 0.0;

            foreach (self::CRITERIA as $column => $config) {
                $xij = (float) $cafe->{$column};

                if ($config['type'] === 'benefit') {
                    // rij = xij / max(xij)
                    $rij = $maxMin[$column]['max'] > 0
                        ? $xij / $maxMin[$column]['max']
                        : 0.0;
                } else {
                    // rij = min(xij) / xij
                    $rij = $xij > 0
                        ? $maxMin[$column]['min'] / $xij
                        : 0.0;
                }

                $normalized[$column] = round($rij, 4);
                $vi += $config['weight'] * $rij;
            }

            $results[] = [
                'cafe' => $cafe,
                'normalized' => $normalized,
                'nilai_akhir' => round($vi, 4),
                'predikat' => $this->getPredikat($vi),
            ];
        }

        // Step 3: Sort descending by Vi and assign ranks
        usort($results, fn (array $a, array $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);

        foreach ($results as $index => &$result) {
            $result['rank'] = $index + 1;
        }

        return [
            'rankings' => $results,
            'criteria' => $this->getCriteriaLabels(),
            'max_min' => $maxMin,
        ];
    }

    /**
     * Determine predikat (label) based on Vi value.
     */
    private function getPredikat(float $vi): string
    {
        return match (true) {
            $vi >= 0.8 => 'Sangat Ideal',
            $vi >= 0.6 => 'Ideal',
            default    => 'Kurang Ideal',
        };
    }

    /**
     * Get human-readable criteria labels with config.
     *
     * @return array<string, array{weight: float, type: string, label: string}>
     */
    public function getCriteriaLabels(): array
    {
        return [
            'wifi_score'     => ['weight' => 0.30, 'type' => 'benefit', 'label' => 'Wifi (C1)'],
            'harga_score'    => ['weight' => 0.25, 'type' => 'cost',    'label' => 'Harga (C2)'],
            'bangunan_score' => ['weight' => 0.17, 'type' => 'cost',    'label' => 'Bangunan (C3)'],
            'luas_score'     => ['weight' => 0.15, 'type' => 'benefit', 'label' => 'Luas (C4)'],
            'jarak_score'    => ['weight' => 0.13, 'type' => 'benefit', 'label' => 'Jarak (C5)'],
        ];
    }
}
