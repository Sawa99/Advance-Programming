<?php

namespace App\Helpers;


class ClassificationHelper{

    //first set threasholds based of uk standards
    const CLASSIFICATIONS = [
        'First'  => 70,
        '2:1'    => 60,
        '2:2'    => 50,
        'Third'  => 40,
    ];

    // set weighting for each module based of University Of Staffs guidelines Level 5 = 30% and level 6 = 60%
    const LEVEL_WEIGHTS = [
        5 => 0.30,
        6 => 0.70,
    ];

    /**
     * Calculate the current module percentage using assignment weights.
     *
     * Each assignment contributes (mark / total_marks) * weight.
     * Only assignments that have a mark are included.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $assignments
     * @return float|null  Current percentage, or null if no marks yet
     */
    public static function modulePercentage($assignments): ?float
    {
        $weightedScore = 0;
        $weightCounted = 0;

        foreach ($assignments as $assignment) {
            if ($assignment->marks->isEmpty()) {
                continue;
            }

            $mark = $assignment->marks->first()->mark;
            $weightedScore += ($mark / $assignment->total_marks) * $assignment->weight;
            $weightCounted += $assignment->weight;
        }

        if ($weightCounted === 0) {
            return null;
        }

        return round(($weightedScore / $weightCounted) * 100, 2);
    }

    /**
     * For a module, calculate what average % is still needed on remaining
     * (unmarked) assignments to achieve each classification overall.
     *
     * Returns:
     *   'Achieved'     — already at or above threshold with current marks
     *   'Not possible' — mathematically impossible even with 100% on remaining
     *   '62.5% avg on remaining assignments' — what they need to hit it
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $assignments
     * @return array  ['First' => mixed, '2:1' => mixed, ...]
     */
    public static function marksStillNeeded($assignments): array
    {
        if ($assignments->isEmpty()) {
            return [
                'First' => 'No assignments',
                '2:1' => 'No assignments',
                '2:2' => 'No assignments',
                'Third' => 'No assignments',
            ];
        }
        $totalWeight = 0;
        $currentWeightedScore = 0;
        $remainingWeight = 0;


        foreach ($assignments as $assignment) {
            $totalWeight += $assignment->weight;

            if ($assignment->marks->isNotEmpty()) {
                $mark = $assignment->marks->first()->mark;
                $currentWeightedScore += ($mark / $assignment->total_marks) * $assignment->weight;
            } else {
                $remainingWeight += $assignment->weight;
            }
        }

        $result = [];

        foreach (self::CLASSIFICATIONS as $label => $threshold) {
            // Score needed: (threshold / 100) * totalWeight
            $neededScore = ($threshold / 100) * $totalWeight;
            $stillNeededScore = $neededScore - $currentWeightedScore;

            if ($stillNeededScore <= 0) {
                $result[$label] = 'Achieved';
                continue;
            }

            if ($remainingWeight === 0) {
                $result[$label] = 'Not possible';
                continue;
            }

            $neededAvgPercent = ($stillNeededScore / $remainingWeight) * 100;

            $result[$label] = $neededAvgPercent > 100
                ? 'Not possible'
                : round($neededAvgPercent, 1) . '% avg on remaining assignments';
        }

        return $result;
    }

    /**
     * Calculate a credit-weighted average percentage for a set of modules.
     *
     * @param  array  $modules  Each: ['percentage' => float, 'credits' => int]
     * @return float|null
     */
    public static function levelWeightedAverage(array $modules): ?float
    {
        $totalCredits  = 0;
        $weightedMarks = 0;

        foreach ($modules as $module) {
            $totalCredits  += $module['credits'];
            $weightedMarks += $module['percentage'] * $module['credits'];
        }

        if ($totalCredits === 0) {
            return null;
        }

        return $weightedMarks / $totalCredits;
    }

    /**
     * Predict the overall degree classification.
     *
     * Completed modules use their actual weight-based percentage.
     * Incomplete modules use the user-supplied predicted percentage.
     * Level 5 = 30%, Level 6 = 70% of the final average.
     *
     * @param  array  $level5Modules  Each: ['percentage' => float, 'credits' => int]
     * @param  array  $level6Modules  Each: ['percentage' => float, 'credits' => int]
     * @return array  ['overall', 'classification', 'level5Average', 'level6Average']
     */

    public static function predictClassification(array $level5Modules, array $level6Modules): array
    {
        $level5Avg = self::levelWeightedAverage($level5Modules);
        $level6Avg = self::levelWeightedAverage($level6Modules);

        $totalWeight = 0;
        $weightedSum = 0;

        if ($level5Avg !== null) {
            $totalWeight += self::LEVEL_WEIGHTS[5];
            $weightedSum += $level5Avg * self::LEVEL_WEIGHTS[5];
        }

        if ($level6Avg !== null) {
            $totalWeight += self::LEVEL_WEIGHTS[6];
            $weightedSum += $level6Avg * self::LEVEL_WEIGHTS[6];
        }

        $overall = $totalWeight > 0 ? round($weightedSum / $totalWeight, 2) : 0;

        return [
            'overall'        => $overall,
            'classification' => self::getClassificationLabel($overall),
            'level5Average'  => $level5Avg !== null ? round($level5Avg, 2) : null,
            'level6Average'  => $level6Avg !== null ? round($level6Avg, 2) : null,
        ];
    }

    public static function getClassificationLabel(float $percentage): string
    {
        foreach (self::CLASSIFICATIONS as $label => $threshold) {
            if ($percentage >= $threshold) {
                return $label;
            }
        }

        return 'Fail';
    }
}
