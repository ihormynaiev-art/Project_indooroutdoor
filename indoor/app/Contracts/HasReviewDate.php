<?php

namespace App\Contracts;

use Carbon\Carbon;

interface HasReviewDate
{
    public function getReviewDate(): Carbon;
}
