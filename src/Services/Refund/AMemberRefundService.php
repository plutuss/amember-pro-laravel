<?php

namespace Plutuss\AMember\Services\Refund;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberRefundService extends AMemberClient implements AMemberRefundInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function invoiceRefunds(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoice-refunds', $id)
        )->sendGet();
    }
}
