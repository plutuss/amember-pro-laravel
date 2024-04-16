<?php

namespace Plutuss\AMember\Services\Payment;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberPaymentInterface
{
    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function invoicePayments(?int $id = null): JsonResponse|array|Collection;
}
