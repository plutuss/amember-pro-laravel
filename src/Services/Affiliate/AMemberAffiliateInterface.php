<?php

namespace Plutuss\AMember\Services\Affiliate;

use Illuminate\Support\Collection;

interface AMemberAffiliateInterface
{
    /**
     * @param int|null $id
     * @return Collection
     */
    public function affPayouts(?int $id = null): \Illuminate\Support\Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function affPayoutDetails(?int $id = null): Collection;
}
