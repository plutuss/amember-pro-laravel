<?php

namespace Plutuss\AMember\Services\Refund;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberRefundInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function invoiceRefunds(?int $id = null): JsonResponse|array|Collection;
}
