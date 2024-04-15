<?php

namespace Plutuss\AMember\Services\Invoice;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberInvoiceService extends AMemberClient implements AMemberParametersApiInterface, AMemberInvoiceInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getInvoiceItems(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/invoice-items', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getInvoice(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/invoices', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getInvoicePayments(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/invoice-payments', $id)
        )->sendGet();
    }



    /**
     * @param int|null $id
     * @return Collection
     */
    public function getAccess(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/access', $id)
        )->sendGet();
    }

}
