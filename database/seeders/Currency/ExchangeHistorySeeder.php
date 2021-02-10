<?php

namespace Database\Seeders\Currency;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExchangeHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_exchange_history')->insert([
            'source' => 'USD',
            'destination' => 'EUR',
            'amount' => 100
        ]);

        DB::table('currency_exchange_history')->insert([
            'source' => 'AUD',
            'destination' => 'USD',
            'amount' => 120
        ]);

        DB::table('currency_exchange_history')->insert([
            'source' => 'CAD',
            'destination' => 'EUR',
            'amount' => 200
        ]);

        DB::table('currency_exchange_history')->insert([
            'source' => 'EUR',
            'destination' => 'AUD',
            'amount' => 340
        ]);

        DB::table('currency_exchange_history')->insert([
            'source' => 'AUD',
            'destination' => 'CAD',
            'amount' => 46
        ]);
    }
}
