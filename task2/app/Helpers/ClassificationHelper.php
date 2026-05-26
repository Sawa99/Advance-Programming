<?php

namespace App\Helpers;

use Illuminate\Support\Collection;


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
     * @return float|null  Current percentage, or null if no marks yet
     */
    public static function modulePercentage($assignments): ?float
    {
        $assignments = collect($assignments);
        $weightedScore = 0;
        $weightCounted = 0;

        foreach ($assignments as $assignment) {
            // Using data_get to handle both objects (models) and arrays
            $marks = data_get($assignment, 'marks');

            if (!$marks || (is_iterable($marks) && count($marks) === 0)) {
                continue;
            }

            $mark = data_get($marks->first(), 'mark');
            $totalMarks = data_get($assignment, 'total_marks');
            $weight = data_get($assignment, 'weight');

            $weightedScore += ($mark / $totalMarks) * $weight;
            $weightCounted += $weight;
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
     *   'Achieved'— already at or above threshold with current marks
     *   'Not possible' — mathematically impossible even with 100% on remaining
     *   '62.5% avg on remaining assignments' — what they need to hit it
     *
     * @return array  ['First' => mixed, '2:1' => mixed, ...]
     */
    public static function marksStillNeeded($assignments): array
    {
        $assignments = collect($assignments);

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
        $remainingTotalMarks = 0;

        foreach ($assignments as $assignment) {
            $weight = data_get($assignment, 'weight');
            $totalWeight += $weight;
            $marks = data_get($assignment, 'marks');

            if ($marks && count($marks) > 0) {
                $mark = data_get($marks->first(), 'mark');
                $assignmentTotalMarks = data_get($assignment, 'total_marks');
                $currentWeightedScore += ($mark / $assignmentTotalMarks) * $weight;
            } else {
                $remainingWeight += $weight;
                $remainingTotalMarks = data_get($assignment, 'total_marks');
            }
        }

        $result = [];
        foreach (self::CLASSIFICATIONS as $label => $threshold) {
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

            $neededAvgMarks = ($stillNeededScore / $remainingWeight) * $remainingTotalMarks;
            $result[$label] = $neededAvgMarks > $remainingTotalMarks
                ? 'Not possible'
                : round($neededAvgMarks, 1) . ' / ' . $remainingTotalMarks . ' on remaining assignments';
        }

        return $result;
    }

    /**
     * Calculate a credit-weighted average percentage for a set of modules.
     *
     * @return float|null
     */
    public static function levelWeightedAverage($modules): ?float
    {
        $modules = collect($modules);

        if ($modules->isEmpty()) {
            return null;
        }

        $totalCredits = $modules->sum(fn($m) => data_get($m, 'credits'));

        if ($totalCredits === 0) {
            return null;
        }

        $weightedMarks = $modules->sum(function ($module) {
            return data_get($module, 'percentage') * data_get($module, 'credits');
        });

        return round($weightedMarks / $totalCredits,2);
    }

    /**
     * Predict the overall degree classification.
     *
     * Completed modules use their actual weight-based percentage.
     * Incomplete modules use the user-supplied predicted percentage.
     * Level 5 = 30%, Level 6 = 70% of the final average.
     *
     * @return array  ['overall', 'classification', 'level5Average', 'level6Average']
     */

    public static function predictClassification($level5Modules,  $level6Modules): array
    {
        $level5Modules = collect($level5Modules);
        $level6Modules = collect($level6Modules);

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
