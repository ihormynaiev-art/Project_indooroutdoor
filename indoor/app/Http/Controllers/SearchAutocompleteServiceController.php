<?php

namespace App\Http\Controllers;

use App\Models\ProviderDetail;
use Illuminate\Http\Request;

class SearchAutocompleteServiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (! empty($search = $request->get('query'))) {
            $services = ProviderDetail::select('provider_details.*')
                ->leftJoin('plans', 'provider_details.plan_id', '=', 'plans.id')
                ->where('business_name', 'like', '%'.$search.'%')
                ->whereHas('user', fn ($q) => $q->where('is_verified', true))
                ->orderByRaw("COALESCE(JSON_EXTRACT(plans.config, '$.features.search_priority'), 0) DESC")
                ->orderBy('provider_details.business_name', 'asc')
                ->limit(5)
                ->get();

            $output = '';
            if (! empty($services->count())) {
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($services as $service) {
                    if (empty($service->parent_id)) {
                        $output .= '<li><a href="'.route('catalog.index', ['search' => $request->get('query')]).'">'.$service->business_name.'</a></li>';
                    }
                }
                $output .= '</ul>';
            }

            echo $output;
        }
    }
}
