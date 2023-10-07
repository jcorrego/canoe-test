<?php

use App\Models\Fund;
use App\Models\Manager;
use App\Models\PotentialDuplicate;

it('creates a fund', function () {
    $response = $this->post('/api/funds', [
        'name' => 'Fund Name',
        'start_year' => date('Y'),
        'manager_id' => 1,
    ]);
    $response->assertStatus(201);
});

it('validates that manager exists before creating a fund', function () {
    $response = $this->post('/api/funds', [
        'name' => 'Fund Name',
        'start_year' => date('Y'),
        'manager_id' => 1000,
    ]);
    $response->assertStatus(302);
});

it('validates that year is provided to create a fund', function () {
    $response = $this->post('/api/funds', [
        'name' => 'Fund Name',
        'start_year' => NULL,
        'manager_id' => 1,
    ]);
    $response->assertStatus(302);
});

it('gets the list of funds', function () {
    // Get the list of funds
    $response = $this->get('/api/funds');
    $content = $response->getContent();
    $decoded = json_decode($content);
    // Check that the number of funds returned is 15
    expect($decoded->data)->toBeArray();
    expect(count($decoded->data))->toBe(15);
});

it('gets the funds filtered by manager_id', function () {
    // Get a random manager
    $manager = Manager::all()->random();
    // Get the funds filtered by the manager's id
    $response = $this->get('/api/funds?manager_id=' . $manager->id);
    $content = $response->getContent();
    $decoded = json_decode($content);
    // Check that the number of funds returned is the same as the number of funds with the same manager
    expect($manager->funds->count())->toBe($decoded->meta->total);
});

it('gets the funds filtered by year', function () {
    // Get a random fund
    $fund = Fund::all()->random();
    // Get the funds filtered by the fund's start year
    $response = $this->get('/api/funds?start_year=' . $fund->start_year);
    $content = $response->getContent();
    $decoded = json_decode($content);
    // Check that the number of funds returned is the same as the number of funds with the same start year
    expect(Fund::where('start_year', $fund->start_year)->count())->toBe($decoded->meta->total);
});

it('updates a Fund name', function () {
    $new_name = 'New Fund Name';
    // Get a random fund
    $fund = Fund::all()->random();
    // Update the fund name using the API
    $response = $this->put('/api/funds/' . $fund->id, [
        'name' => $new_name,
    ]);
    // Check that the fund name has been updated
    $fund->refresh();
    expect($fund->name)->toBe($new_name);
});

it('detects a potential duplicate', function () {
    // Get a random fund
    $fund = Fund::all()->random();
    // Get the number of potential duplicates for this fund
    $duplicates = PotentialDuplicate::where('duplicate_fund_id', $fund->id)->count();
    // Create a new fund with the same name and manager
    $response = $this->post('/api/funds', [
        'name' => $fund->name,
        'start_year' => date('Y'),
        'manager_id' => $fund->manager_id,
    ]);
    // Check that the number of potential duplicates has increased by 1
    expect(PotentialDuplicate::where('duplicate_fund_id', $fund->id)->count())->toBe($duplicates + 1);

});
