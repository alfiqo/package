<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    //  vendor/bin/phpunit --filter test_get_all_package
    public function test_get_all_package()
    {
        $this->get(route('packages.index'))
            ->assertStatus(200);
    }

    // vendor/bin/phpunit --filter test_show_package
    public function test_show_package()
    {
        $transaction_id = 'd0090c40-539f-479a-8274-899b9970bdda';
        $request = $this->call('GET', 'api/packages', ["package" => $transaction_id])
            ->assertStatus(200);
    }

    // vendor/bin/phpunit --filter test_create_package
    public function test_create_package()
    {

        $data = $json = '{"transaction_id": "d0090c40-539f-479a-8274-899b9970bdda","customer_name": "PT. AMARA PRIMATIGA"}';
        $data = json_decode($json, true);

        $this->post(route('packages.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    // vendor/bin/phpunit --filter test_update_package
    public function test_update_package()
    {
        $transaction_id = 'd0090c40-539f-479a-8274-899b9970bdda';
        $package = Package::find($transaction_id);
        
        $data = $json = '{"customer_name": "PT. AMARA PRIMATIGA ABADI"}';
        $data = json_decode($json, true);

        $this->patch(route('packages.update', $transaction_id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function test_delete_package()
    {
        $transaction_id = 'd0090c40-539f-479a-8274-899b9970bdda';

        $request = $this->call('DETELE', 'api/packages', ["package" => $transaction_id])
            ->assertStatus(200);
    }
}
