<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer\Customer;
use App\Models\Order\Order;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers =[ 
            [
                'name' => 'Sergios',
                'email' => 'sergios@gmail.com',
                'phone' => 9080706050,
                'address' => 'Cypruss',
            ],
            [
                'name' => 'Leonardis',
                'email' => 'leonardis@gmail.com',
                'phone' => 9080706040,
                'address' => 'Cypruss',
            ]
        ];

        foreach ($customers as $key => $customerArray) {
            $res = save($customerArray, new Customer());

            if ($res) {
                $orders = [
                    [
                        'customer_id' => $res,
                        'product_name' => 'Laptop',
                        'quantity' => 1,
                        'price_per_quantity' => 1000,
                        'total_price' => 1000,
                    ],
                    [
                        'customer_id' => $res,
                        'product_name' => 'Charger',
                        'quantity' => 1,
                        'price_per_quantity' => 50,
                        'total_price' => 50,
                    ]
                ];
                foreach ($orders as $key => $orderArray) {
                    save($orderArray, new Order());
                }
            }

        }

        
    }
}
