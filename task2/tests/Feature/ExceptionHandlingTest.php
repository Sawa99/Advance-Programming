<?php

Use App\Models\User;

test('it handles missing modules by returning a 404 error', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/modules/99999');

    $response->assertStatus(404);
});
