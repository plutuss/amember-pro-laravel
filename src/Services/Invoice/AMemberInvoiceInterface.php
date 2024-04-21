<?php

namespace Plutuss\AMember\Services\Invoice;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;


interface AMemberInvoiceInterface
{
    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getInvoiceItems(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getInvoice(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param array $data
     * @return JsonResponse|array|Collection
     */
    public function setInvoice(array $data): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getInvoicePayments(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getAccess(?int $id = null): JsonResponse|array|Collection;
}
