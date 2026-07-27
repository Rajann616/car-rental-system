<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin AutoLux',
            'email' => 'admin@AutoLux.in',
            'phone' => '9876543210',
            'address' => '123 SG Highway, Near Iskcon Temple',
            'city' => 'Ahmedabad',
            'state' => 'Gujarat',
            'pincode' => '380015',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);

        // Sample Customers
        $customers = [
            [
                'name' => 'Rajesh Patel',
                'email' => 'rajesh.patel@gmail.com',
                'phone' => '9876543211',
                'address' => '45 CG Road, Navrangpura',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380009',
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@gmail.com',
                'phone' => '9876543212',
                'address' => '78 Satellite Road, Near Jodhpur Cross Roads',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
            ],
            [
                'name' => 'Amit Desai',
                'email' => 'amit.desai@gmail.com',
                'phone' => '9876543213',
                'address' => '12 Vastrapur Lake Road',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
            ],
            [
                'name' => 'Sneha Joshi',
                'email' => 'sneha.joshi@gmail.com',
                'phone' => '9876543214',
                'address' => '56 Law Garden, Ellis Bridge',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380006',
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram.singh@gmail.com',
                'phone' => '9876543215',
                'address' => '34 Bodakdev, Near Judges Bungalow',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380054',
            ],
        ];

        foreach ($customers as $customer) {
            User::create(array_merge($customer, [
                'role' => 'customer',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
            ]));
        }
    }
}
