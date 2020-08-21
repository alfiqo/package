<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Package;

class PackageTest extends TestCase
{
    /**
     * A basic unit test example.
     * Test All => ./vendor/bin/phpunit tests/Unit
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

        $json = '{
            "transaction_id": "d0090c40-539f-479a-8274-899b9970bdu0",
            "customer_name": "PT. AMARA PRIMATIGA",
            "customer_code": "1678593",
            "transaction_amount": "70700",
            "transaction_discount": "0",
            "transaction_additional_field": "",
            "transaction_payment_type": "29",
            "transaction_state": "PAID",
            "transaction_code": "CGKFT20200715121",
            "transaction_order": 121,
            "location_id": "5cecb20b6c49615b174c3e74",
            "organization_id": 6,
            "created_at": "2020-07-15 11:11:12",
            "updated_at": "2020-07-15 11:11:22",
            "transaction_payment_type_name": "Invoice",
            "transaction_cash_amount": 0,
            "transaction_cash_change": 0
        }';

        $data = json_decode($json, true);

        $this->json('POST', '/api/packages', $data)
            ->assertStatus(200);
    }

    // vendor/bin/phpunit --filter test_update_package
    public function test_update_package()
    {
        $package = factory(Package::class)->create();

        $json = '{
            "transaction_id": "d0090c40-539f-479a-8274-899b9970bdu0",
            "customer_name": "PT. AMARA",
            "customer_code": "1678593",
            "transaction_amount": "70700",
            "transaction_discount": "0",
            "transaction_additional_field": "",
            "transaction_payment_type": "29",
            "transaction_state": "PAID",
            "transaction_code": "CGKFT20200715121",
            "transaction_order": 121,
            "location_id": "5cecb20b6c49615b174c3e74",
            "organization_id": 6,
            "created_at": "2020-07-15 11:11:12",
            "updated_at": "2020-07-15 11:11:22",
            "transaction_payment_type_name": "Invoice",
            "transaction_cash_amount": 0,
            "transaction_cash_change": 0
        }';
        $data = json_decode($json, true);

        $this->json('PUT', '/api/packages/' . $package->transaction_id, $data)
            ->assertStatus(200);
    }

    public function test_delete_package()
    {
        $package = factory(Package::class)->create();
        $this->json('DELETE', '/api/packages/' . $package->transaction_id)
            ->assertStatus(200);
    }
}
