<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  
        Order::create([
            'model'         => 'TR5003WN',
            'category'      => 'Laundry',
            'ordered_qty'   => '5',
            'current_qty'   => '5',
            'average_price' => '999',
        ]);

        Order::create([
            'model'         => '123',
            'category'      => 'Dishwaser',
            'ordered_qty'   => '0',
            'current_qty'   => '10',
            'average_price' => '100',
        ]);

        Order::create([
            'model'         => '3455',
            'category'      => 'Refrigeration',
            'ordered_qty'   => '7',
            'current_qty'   => '0',
            'average_price' => '699',
        ]);
    }
}
