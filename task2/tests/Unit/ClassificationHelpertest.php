<?php

use App\Helpers\ClassificationHelper;

// sets fake assigment for testing
function fakeAssignment(float $earnedMark, float $totalMarks, float $weight, bool $hasMarks = true): object
{
    return (object) [
        'marks'       => $hasMarks
            ? collect([(object) ['mark' => $earnedMark]])
            : collect([]),
        'total_marks' => $totalMarks,
        'weight'      => $weight,
    ];
}

//Testing Model Percentage function

test('modulePercentage returns null when no assignments have marks', function () {
    $assignments = collect([
        fakeAssignment(0, 100, 50, false),
        fakeAssignment(0, 100, 50, false),
    ]);

    $result = ClassificationHelper::modulePercentage($assignments);

    expect($result)->toBeNull();
});

test('modulePercentage calculates correctly for a single marked assignment', function () {
    $assignments = collect([fakeAssignment(70, 100, 100)]);

    $result = ClassificationHelper::modulePercentage($assignments);

    expect($result)->toBe(70.0);
});

test('modulePercentage calculates weighted average across multiple assignments', function () {
    $assignments = collect([
        fakeAssignment(80, 100, 60),
        fakeAssignment(50, 100, 40),
    ]);

    $result = ClassificationHelper::modulePercentage($assignments);

    expect($result)->toBe(68.0);
});

test('modulePercentage skips assignments with no marks', function () {
    $assignments = collect([
        fakeAssignment(60, 100, 60),
        fakeAssignment(0, 100, 40, false), // no marks yet
    ]);

    $result = ClassificationHelper::modulePercentage($assignments);

    expect($result)->toBe(60.0);
});

test('modulePercentage rounds to two decimal places', function () {
    $assignments = collect([fakeAssignment(2, 3, 100)]);

    $result = ClassificationHelper::modulePercentage($assignments);

    expect($result)->toBe(66.67);
});

//Testing markStillNeeded function
test('marksStillNeeded returns No assignments for all bands when collection is empty', function () {
    $result = ClassificationHelper::marksStillNeeded(collect([]));

    expect($result)->toBe([
        'First'  => 'No assignments',
        '2:1'    => 'No assignments',
        '2:2'    => 'No assignments',
        'Third'  => 'No assignments',
    ]);
});

test('marksStillNeeded returns Achieved for bands already met', function () {

    $assignments = collect([fakeAssignment(80, 100, 100)]);

    $result = ClassificationHelper::marksStillNeeded($assignments);

    expect($result['First'])->toBe('Achieved');
    expect($result['2:1'])->toBe('Achieved');
    expect($result['2:2'])->toBe('Achieved');
    expect($result['Third'])->toBe('Achieved');
});

test('marksStillNeeded returns Not possible when remaining weight cannot bridge the gap', function () {
    $assignments = collect([
        fakeAssignment(0, 100, 60),
        fakeAssignment(0, 100, 40),
    ]);

    $result = ClassificationHelper::marksStillNeeded($assignments);

    expect($result['First'])->toBe('Not possible');
    expect($result['2:1'])->toBe('Not possible');
});

test('marksStillNeeded returns avg percentage string for reachable bands', function () {
    $assignments = collect([
        fakeAssignment(0, 100, 60),
        fakeAssignment(0, 100, 40, false),
    ]);

    $result = ClassificationHelper::marksStillNeeded($assignments);

    expect($result['Third'])->toContain('% avg on remaining assignments');
});

//Testing levelWeightedAverage function
test('levelWeightedAverage returns null when given an empty array', function () {
    $result = ClassificationHelper::levelWeightedAverage([]);

    expect($result)->toBeNull();
});

test('levelWeightedAverage calculates credit-weighted average correctly', function () {
    $modules = [
        ['percentage' => 70, 'credits' => 20],
        ['percentage' => 50, 'credits' => 20],
    ];

    $result = ClassificationHelper::levelWeightedAverage($modules);

    expect($result)->toBe(60.0);
});

test('levelWeightedAverage weights higher-credit modules more', function () {
    $modules = [
        ['percentage' => 80, 'credits' => 40],
        ['percentage' => 40, 'credits' => 20],
    ];

    $result = ClassificationHelper::levelWeightedAverage($modules);

    expect($result)->toBe(66.67);
});

//Testing getClassificationLabel function
test('getClassificationLabel returns First for 70 and above', function () {
    expect(ClassificationHelper::getClassificationLabel(70))->toBe('First');
    expect(ClassificationHelper::getClassificationLabel(85))->toBe('First');
});

test('getClassificationLabel returns 2:1 for 60 to 69', function () {
    expect(ClassificationHelper::getClassificationLabel(60))->toBe('2:1');
    expect(ClassificationHelper::getClassificationLabel(65))->toBe('2:1');
});

test('getClassificationLabel returns 2:2 for 50 to 59', function () {
    expect(ClassificationHelper::getClassificationLabel(50))->toBe('2:2');
    expect(ClassificationHelper::getClassificationLabel(55))->toBe('2:2');
});

test('getClassificationLabel returns Third for 40 to 49', function () {
    expect(ClassificationHelper::getClassificationLabel(40))->toBe('Third');
    expect(ClassificationHelper::getClassificationLabel(45))->toBe('Third');
});

test('getClassificationLabel returns Fail for below 40', function () {
    expect(ClassificationHelper::getClassificationLabel(39))->toBe('Fail');
    expect(ClassificationHelper::getClassificationLabel(0))->toBe('Fail');
});

//Testing predictClassification function
test('predictClassification returns correct overall and classification', function () {
    $level5 = [
        ['percentage' => 60, 'credits' => 20],
    ];
    $level6 = [
        ['percentage' => 70, 'credits' => 20],
    ];

    $result = ClassificationHelper::predictClassification($level5, $level6);

    expect($result['overall'])->toBe(67.0);
    expect($result['classification'])->toBe('2:1');
    expect($result['level5Average'])->toBe(60.0);
    expect($result['level6Average'])->toBe(70.0);
});

test('predictClassification returns overall 0 when both levels are empty', function () {
    $result = ClassificationHelper::predictClassification([], []);

    expect($result['overall'])->toBe(0);
    expect($result['level5Average'])->toBeNull();
    expect($result['level6Average'])->toBeNull();
});

test('predictClassification uses only level 6 when level 5 is empty', function () {
    $level6 = [
        ['percentage' => 80, 'credits' => 20],
    ];

    $result = ClassificationHelper::predictClassification([], $level6);

    expect($result['level5Average'])->toBeNull();
    expect($result['level6Average'])->toBe(80.0);
    expect($result['classification'])->toBe('First');
});
