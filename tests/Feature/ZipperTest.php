<?php

use Gnarhard\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();
});

test('confirm environment is set to testing', function () {
    expect(config('app.env'))->toBe('workbench');
});

it('returns false if source has 0 files', function () {
    Storage::makeDirectory('empty_directory');

    $result = Zipper::create('empty_directory', 'destination.zip');

    expect($result)->toBeFalse();
});

it('successfully creates a zip file with files and directories', function () {
    $sourcePath = 'test_directory';

    // Setup: Create dummy files on fake disk
    Storage::put("$sourcePath/test_file.txt", 'This is a test file');
    Storage::put("$sourcePath/other_test_file_directory/other_test_file.txt", 'This is the other test file');

    // Action: Attempt to create a zip file
    $result = Zipper::create($sourcePath, 'destination.zip');

    // Assert: Check if the zip file was created successfully
    expect($result)->toBeTrue();

    // unzip file
    $zip = new ZipArchive();
    $zip->open(Storage::path('destination.zip'));
    $zip->extractTo(Storage::path("unzipped"));
    $zip->close();

    // check directories
    expect(Storage::directories("unzipped"))->toContain('unzipped/other_test_file_directory');

    expect(Storage::files("unzipped"))->toBe([
        'unzipped/test_file.txt',
    ]);

    expect(Storage::files("unzipped/other_test_file_directory"))->toBe([
        'unzipped/other_test_file_directory/other_test_file.txt',
    ]);

    // cleanup
    Storage::deleteDirectory('test_directory');
    Storage::deleteDirectory('unzipped');
    Storage::delete('destination.zip');
});
