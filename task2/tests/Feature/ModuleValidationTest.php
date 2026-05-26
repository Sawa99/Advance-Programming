<?php

use App\Models\User;


test('it validates that a module name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('modules.store'), [
        'name' => '',
        'credits' => 20,
        'level' => 5,
        'is_completed' => false,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('it validates that module credits cannot be negative', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('modules.store'), [
            'name' => 'Valid Name',
            'credits' => -10, // Invalid input
            'level' => 5,
        ]);

    $response->assertSessionHasErrors(['credits']);
});
