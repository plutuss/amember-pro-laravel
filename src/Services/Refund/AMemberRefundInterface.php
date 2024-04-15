<?php

namespace Plutuss\AMember\Services\Refund;

use Illuminate\Support\Collection;

interface AMemberRefundInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function invoiceRefunds(?int $id = null): Collection;
}
