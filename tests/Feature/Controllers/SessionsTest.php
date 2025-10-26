<?php

it('returns all sessions', function () {
    $this->post(route('login.store'), [
        'email' => user()->email,
        'password' => 'password'
    ]);

    $sessions = $this->get(route('sessions.index'))->json('sessions');

    expect($sessions)
        ->toHaveCount(1)
        ->toHaveKey('0.ip_address')
        ->and(Arr::get($sessions, '0.ip_address'))
        ->toEqual(DB::table('sessions')->first()->ip_address);
});