<?php

use Gnarhard\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\Storage;

it('checks if PHP Zip extension is loaded', function () {
    expect(extension_loaded('zip'))->toBeTrue();
});

it('returns false if the source does not exist', function () {
    $result = Zipper::create('non_existing_source', 'destination.zip');

    expect($result)->toBeFalse();
});

it('returns false if source or destination is empty', function () {
    $result = Zipper::create('', '');

    expect($result)->toBeFalse();
});