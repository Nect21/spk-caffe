<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class SmartCalculatorService
{
    /**
     * Criteria configuration: column => [weight, type]
     */
    private const array CRITERIA = [
        'wifi_score'     => ['weight' => 0.30, 'type' => 'benefit'],
        'harga_score'    => ['weight' => 0.25, 'type' => 'cost'],
        'bangunan_score' => ['weight' => 0.17, 'type' => 'cost'],
        'luas_score'     => ['weight' => 0.15, 'type' => 'benefit'],
        'jarak_score'    => ['weight' => 0.13, 'type' => 'benefit'],
    ];

    /**
     * Calculate SMART rankings for a collection of cafes.
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
            
            $c_max = $values->max() ?: 1.0;
            $c_min = $values->min() ?: 0.2;

            $maxMin[$column] = [
                'max' => $c_max,
                'min' => $c_min,
            ];
        }

        // Step 2: Calculate Utility (Normalization) and Vi for each cafe
        $results = [];
        foreach ($cafes as $cafe) {
            $normalized = [];
            $vi = 0.0;

            foreach (self::CRITERIA as $column => $config) {
                $xij = (float) $cafe->{$column};
                $c_max = $maxMin[$column]['max'];
                $c_min = $maxMin[$column]['min'];
                $denominator = $c_max - $c_min;

                if ($denominator == 0) {
                    // Jika max == min (contoh: hanya ada 1 cafe, atau semua cafe nilainya sama persis),
                    // maka utility dianggap sempurna (1.0) untuk kriteria ini, sama seperti SAW.
                    $u_i = 1.0;
                } else {
                    if ($config['type'] === 'benefit') {
                        $u_i = ($xij - $c_min) / $denominator;
                    } else {
                        $u_i = ($c_max - $xij) / $denominator;
                    }
                }

                // Make sure utility is between 0 and 1 (in case of weird data)
                $u_i = max(0.0, min(1.0, $u_i));

                $normalized[$column] = round($u_i, 4);
                $vi += $config['weight'] * $u_i;
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
