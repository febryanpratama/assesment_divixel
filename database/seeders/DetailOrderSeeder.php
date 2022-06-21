<?php

namespace Database\Seeders;

use App\Models\DetailOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DetailOrder::create([
            'order_id'      => '1',
            'qty'           => '1',
            'invoice'       => 'INV/2022/1',
            'price'         => '999'
        ]);

        DetailOrder::create([
            'order_id'      => '1',
            'qty'           => '2',
            'invoice'       => 'INV/2022/2',
            'price'         => '999'
        ]);

        DetailOrder::create([
            'order_id'      => '1',
            'qty'           => '2',
            'invoice'       => 'INV/2022/3',
            'price'         => '999'
        ]);
    }
}
