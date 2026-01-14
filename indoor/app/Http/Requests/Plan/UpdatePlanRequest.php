<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'super admin']);
    }

    public function rules(): array
    {
        return [
            'display_name' => 'required|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',

            'config.features.max_portfolio_photos' => 'required|integer|min:1|max:100',
            'config.features.show_map' => 'boolean',
            'config.features.show_promo_block' => 'boolean',
            'config.features.seo_follow' => 'boolean',
            'config.features.search_priority' => 'boolean',
            'config.features.landing' => 'boolean',

            'config.reviews.indooroutdoor' => 'boolean',
            'config.reviews.google' => 'boolean',
            'config.reviews.facebook' => 'boolean',

            'config.contact_buttons.message_provider' => 'boolean',
            'config.contact_buttons.request_quote' => 'boolean',
            'config.contact_buttons.share_profile' => 'boolean',

            'config.ad_buttons.view_ad' => 'boolean',
            'config.ad_buttons.view_magazine' => 'boolean',

            'config.limits.lead_delay_hours' => 'required|integer|min:0|max:168',

            'config.admin.auto_publish' => 'boolean',
        ];
    }
}
