<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'), 
            'role' => 'admin',
            'account_id' => '000001', 
            'email_verified_at' => now(),
        ]);

        $company = Company::create([
            'name' => 'Tech Solutions Co.',
            'email' => 'info@tech.com',
            'address' => 'Riyadh',
            'plan' => 'pro',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Ahmed Manager',
            'email' => 'creditor@app.com',
            'password' => Hash::make('12345678'),
            'role' => 'creditor',
            'company_id' => $company->id,
            'company_role' => 'owner',
            'company_name' => 'Tech Solutions Co.',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Khaled Client',
            'email' => 'debtor@app.com',
            'password' => Hash::make('12345678'),
            'role' => 'debtor',
            'email_verified_at' => now(),
        ]);
    }
}