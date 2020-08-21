<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Package;
use Faker\Generator as Faker;

$factory->define(Package::class, function (Faker $faker) {

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

    return $data;
});
