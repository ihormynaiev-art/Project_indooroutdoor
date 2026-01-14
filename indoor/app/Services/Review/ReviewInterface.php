<?php

namespace App\Services\Review;

use App\Models\ProviderDetail;

interface ReviewInterface
{
    public function updateAll(): void;

    public function updateOne(ProviderDetail $provider): void;
}
