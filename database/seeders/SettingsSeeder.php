<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Terms and Privacy Settings
            ['key' => 'rep_terms', 'value' => 'Representative Terms and Conditions content here...'],
            ['key' => 'client_terms', 'value' => 'Client Terms and Conditions content here...'],
            ['key' => 'privacy_partner', 'value' => 'Partner Privacy Policy content here...'],
            ['key' => 'privacy_client', 'value' => 'Client Privacy Policy content here...'],
            ['key' => 'company_terms', 'value' => 'Company Terms and Conditions content here...'],
            
            // Order and Delivery Settings
            ['key' => 'order_percentage', 'value' => '0'],
            ['key' => 'rep_order_percentage', 'value' => '0'],
            ['key' => 'km_initial_cost_rep_order', 'value' => '0'],
            ['key' => 'max_delivery_cost_rep_order', 'value' => '0'],
            ['key' => 'delivery_initial_cost_rep_order', 'value' => '0'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
