<?php

namespace Plutuss\AMember\Services\Affiliate;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberAffiliateInterface
{
    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function affPayouts(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function affPayoutDetails(?int $id = null): JsonResponse|array|Collection;
}
