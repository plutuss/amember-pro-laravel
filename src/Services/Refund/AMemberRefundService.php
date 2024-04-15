<?php

namespace Plutuss\AMember\Services\Refund;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberRefundService extends AMemberClient implements AMemberRefundInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function invoiceRefunds(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/invoice-refunds', $id)
        )->sendGet();
    }
}
