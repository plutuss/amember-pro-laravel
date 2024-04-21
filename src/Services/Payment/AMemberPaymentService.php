<?php

namespace Plutuss\AMember\Services\Payment;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberPaymentService extends AMemberClient implements AMemberPaymentInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function invoicePayments(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/invoice-payments', $id)
        )->sendGet();
    }

}
