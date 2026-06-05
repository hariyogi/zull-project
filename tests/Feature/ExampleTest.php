<?php

test('the application returns a successful response', function () {
    $response = $this->get('/login/staff');

    $response->assertStatus(200);
});
