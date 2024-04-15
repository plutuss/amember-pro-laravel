<?php

namespace Plutuss\AMember\Services\Payment;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberPaymentService extends AMemberClient implements AMemberPaymentInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function invoicePayments(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/invoice-payments', $id)
        )->sendGet();
    }

}
