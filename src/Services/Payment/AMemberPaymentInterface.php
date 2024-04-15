<?php

namespace Plutuss\AMember\Services\Payment;

use Illuminate\Support\Collection;

interface AMemberPaymentInterface
{
    /**
     * @param int|null $id
     * @return mixed
     */
    public function invoicePayments(?int $id = null): Collection;
}
