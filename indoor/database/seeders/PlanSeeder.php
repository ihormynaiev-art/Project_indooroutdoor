<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::query()
            ->updateOrCreate(
                ['name' => 'lite'],
                [
                    'display_name' => 'Lite',
                    'is_active' => true,
                    'sort_order' => 1,
                    'config' => [
                        'features' => [
                            'max_portfolio_photos' => 3,
                            'show_map' => false,
                            'show_promo_block' => false,
                            'seo_follow' => false,
                            'search_priority' => false,
                            'can_upload_background' => false,
                            'landing' => false,
                        ],
                        'reviews' => [
                            'indooroutdoor' => true,
                            'google' => false,
                            'facebook' => false,
                        ],
                        'contact_buttons' => [
                            'message_provider' => false,
                            'share_profile' => false,
                        ],
                        'ad_buttons' => [
                            'view_ad' => false,
                            'view_magazine' => true,
                        ],
                        'limits' => [
                            'lead_delay_hours' => 48,
                        ],
                        'admin' => [
                            'auto_publish' => false,
                        ],
                    ],
                ]
            );

        Plan::query()
            ->updateOrCreate(
                ['name' => 'premium'],
                [
                    'display_name' => 'Premium',
                    'is_active' => true,
                    'sort_order' => 2,
                    'config' => [
                        'features' => [
                            'max_portfolio_photos' => 20,
                            'show_map' => true,
                            'show_promo_block' => true,
                            'seo_follow' => true,
                            'search_priority' => true,
                            'can_upload_background' => true,
                            'landing' => true,
                        ],
                        'reviews' => [
                            'indooroutdoor' => true,
                            'google' => true,
                            'facebook' => true,
                        ],
                        'contact_buttons' => [
                            'message_provider' => true,
                            'share_profile' => true,
                        ],
                        'ad_buttons' => [
                            'view_ad' => true,
                            'view_magazine' => true,
                        ],
                        'limits' => [
                            'lead_delay_hours' => 0,
                        ],
                        'admin' => [
                            'auto_publish' => true,
                        ],
                    ],
                ]
            );
    }
}
