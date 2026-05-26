<?php

use App\Models\Module;

test('unauthenticated user cannot create a module and is redirected to login', function () {
    $moduleData = Module::factory()->make()->toArray();

    $response = $this->post('/modules', $moduleData);

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});
