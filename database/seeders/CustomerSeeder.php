<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'EDGAR FRANCO',
                'type' => 'Persona fisica',
                'document_type' => 'CI',
                'document_number' => '5269764',
                'fantasy_name' => 'EDGAR FRANCO',
                'phone' => '991192301',
                'phone_alt' => '991192301',
                'email' => 'edfsosa@gmail.com',
                'is_gov_supplier' => false,
                'operation_type' => 'B2C',
            ],
        ];

        foreach ($customers as $data) {
            Customer::updateOrCreate(
                ['name' => $data['name']],
                [
                    'type' => $data['type'],
                    'document_type' => $data['document_type'],
                    'document_number' => $data['document_number'],
                    'fantasy_name' => $data['fantasy_name'],
                    'phone' => $data['phone'],
                    'phone_alt' => $data['phone_alt'],
                    'email' => $data['email'],
                    'is_gov_supplier' => $data['is_gov_supplier'],
                    'operation_type' => $data['operation_type'],
                ]
            );
        }
    }
}
