<?php

use AlizHarb\Modular\Facades\Modular;
use Illuminate\Support\Facades\Config;

// dd(get_class(app()));

it('can resolve config facade', function () {
    expect(Config::get('app.name'))->toBeString();
});

it('can resolve modular facade', function () {
    expect(Modular::getFacadeRoot())->not->toBeNull();
});
