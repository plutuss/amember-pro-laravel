<?php

namespace Plutuss\AMember\Services\Invoice;

use Illuminate\Support\Collection;

interface AMemberInvoiceInterface
{
    /**
     * @param int|null $id
     * @return Collection
     */
    public function getInvoiceItems(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getInvoice(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getInvoicePayments(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getAccess(?int $id = null): Collection;
}
