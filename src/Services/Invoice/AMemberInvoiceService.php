<?php

namespace Plutuss\AMember\Services\Invoice;


use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberInvoiceService extends AMemberClient implements AMemberParametersApiInterface, AMemberInvoiceInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
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
     * @throws ConnectionException
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
     * @throws ConnectionException
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
     * @throws ConnectionException
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
     * @throws ConnectionException
     */
    public function setInvoice(array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoices'), $data
        )->sendPost();
    }

    /**
     * @param int $id
     * @param array $data
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function updateInvoice(int $id, array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoices', $id), $data
        )->sendPut();
    }
}
