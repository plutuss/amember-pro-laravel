<?php

namespace Plutuss\AMember\Services\Invoice;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberInvoiceService extends AMemberClient implements AMemberParametersApiInterface, AMemberInvoiceInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getInvoiceItems(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoice-items', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getInvoice(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoices', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getInvoicePayments(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoice-payments', $id)
        )->sendGet();
    }
    
    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getAccess(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/access', $id)
        )->sendGet();
    }

    /**
     * @param array $data
     * @return JsonResponse|array|Collection
     */
    public function setInvoice(array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoices'), $data
        )->sendPost();
    }
}
