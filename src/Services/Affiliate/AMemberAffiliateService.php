<?php

namespace Plutuss\AMember\Services\Affiliate;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;
use Plutuss\AMember\Services\Affiliate\AMemberAffiliateInterface;

class AMemberAffiliateService extends AMemberClient implements AMemberAffiliateInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function affPayouts(?int $id = null): \Illuminate\Support\Collection
    {
        return $this->setOption(
            url_join('/aff-payouts', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function affPayoutDetails(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/aff-payout-details', $id)
        )->sendGet();
    }

}
