<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class WpCalculatorService
{
    /**
     * Criteria configuration: column => [weight, type]
     * Benefit: power is positive (w)
     * Cost:    power is negative (-w)
     */
    private const array CRITERIA = [
        'wifi_score'     => ['weight' => 0.30, 'type' => 'benefit'],
        'harga_score'    => ['weight' => 0.25, 'type' => 'cost'],
        'bangunan_score' => ['weight' => 0.17, 'type' => 'cost'],
        'luas_score'     => ['weight' => 0.15, 'type' => 'benefit'],
        'jarak_score'    => ['weight' => 0.13, 'type' => 'benefit'],
    ];

    /**
     * Calculate WP rankings for a collection of cafes.
     *
     * @param  Collection  $cafes  Collection of Cafe models
     * @return array{
     *     rankings: array<int, array{
     *         cafe: \App\Models\Cafe,
     *         s_value: float,
     *         nilai_akhir: float,
     *         predikat: string,
     *         rank: int
     *     }>,
     *     criteria: array<string, array{weight: float, type: string, label: string}>
     * }
     */
    public function calculate(Collection $cafes): array
    {
        if ($cafes->isEmpty()) {
            return [
                'rankings' => [],
                'criteria' => $this->getCriteriaLabels(),
            ];
        }

        $results = [];
        $totalS = 0.0;

        // Step 1: Calculate S for each cafe
        foreach ($cafes as $cafe) {
            $si = 1.0;

            foreach (self::CRITERIA as $column => $config) {
                $xij = (float) $cafe->{$column};
                // To avoid 0^negative which is undefined or infinity
                if ($xij <= 0) {
                    $xij = 0.001; 
                }

                $power = $config['type'] === 'benefit' ? $config['weight'] : -$config['weight'];
                $si *= pow($xij, $power);
            }

            $results[] = [
                'cafe' => $cafe,
                's_value' => $si,
            ];
            
            $totalS += $si;
        }

        // Step 2: Calculate V (nilai akhir) for each cafe
        foreach ($results as &$result) {
            $vi = $totalS > 0 ? $result['s_value'] / $totalS : 0.0;
            $result['nilai_akhir'] = round($vi, 4);
            $result['s_value'] = round($result['s_value'], 4);
            $result['predikat'] = $this->getPredikat($vi, count($cafes));
        }
        unset($result);

        // Step 3: Sort descending by V (nilai akhir) and assign ranks
        usort($results, fn (array $a, array $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);

        foreach ($results as $index => &$result) {
            $result['rank'] = $index + 1;
        }

        return [
            'rankings' => $results,
            'criteria' => $this->getCriteriaLabels(),
        ];
    }

    /**
     * Determine predikat (label) based on Vi value.
     * Since V values depend on the number of alternatives (sum of V is 1),
     * we adjust thresholds based on average V.
     */
    private function getPredikat(float $vi, int $totalAlternatives): string
    {
        if ($totalAlternatives <= 0) return 'Kurang Ideal';
        
        $averageV = 1.0 / $totalAlternatives;
        
        // Example dynamic thresholds based on average V
        return match (true) {
            $vi >= $averageV * 1.5 => 'Sangat Ideal',
            $vi >= $averageV * 1.0 => 'Ideal',
            default    => 'Kurang Ideal',
        };
    }

    /**
     * Get human-readable criteria labels with config.
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
