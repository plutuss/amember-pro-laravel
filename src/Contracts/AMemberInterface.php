<?php

namespace Plutuss\AMember\Contracts;

use Plutuss\AMember\Services\Auth\AMemberCheckAccessInterface;
use Plutuss\AMember\Services\Invoice\AMemberInvoiceInterface;
use Plutuss\AMember\Services\Payment\AMemberPaymentInterface;
use Plutuss\AMember\Services\Users\AMemberUserInterface;

interface AMemberInterface
{
    /**
     * @return AMemberCheckAccessInterface|AMemberParametersApiInterface
     */
    public function auth(): AMemberCheckAccessInterface|AMemberParametersApiInterface;

    /**
     * @return AMemberParametersApiInterface|AMemberInvoiceInterface
     */
    public function invoice(): AMemberParametersApiInterface|AMemberInvoiceInterface;

    /**
     * @return AMemberPaymentInterface|AMemberParametersApiInterface
     */
    public function payment(): AMemberPaymentInterface|AMemberParametersApiInterface;

    /**
     * @return AMemberUserInterface|AMemberParametersApiInterface
     */
    public function users(): AMemberUserInterface|AMemberParametersApiInterface;
}
