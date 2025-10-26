<?php

beforeEach(function () {
    $this->user = user();
});

//Create
it('Return the corresponding page', function () {
    $this->withoutExceptionHandling();
    login($this->user)
        ->get(route('dashboard.show'))
        ->assertComponentIs('Dashboard/Show');
});
