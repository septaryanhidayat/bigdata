<?php

test('the application returns a successful response', function () {
    $this->seed();
    $response = $this->get('/');

    $response->assertStatus(200);
});
