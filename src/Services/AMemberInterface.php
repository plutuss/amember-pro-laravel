<?php

namespace Plutuss\AMember\Services;

use Plutuss\AMember\Contracts\AMemberParametersApiInterface;
use Plutuss\AMember\Services\Access\AMemberAccessInterface;
use Plutuss\AMember\Services\Affiliate\AMemberAffiliateInterface;
use Plutuss\AMember\Services\Auth\AMemberCheckAccessInterface;
use Plutuss\AMember\Services\Form\AMemberFormInterface;
use Plutuss\AMember\Services\Invoice\AMemberInvoiceInterface;
use Plutuss\AMember\Services\Payment\AMemberPaymentInterface;
use Plutuss\AMember\Services\Product\AMemberProductInterface;
use Plutuss\AMember\Services\Refund\AMemberRefundInterface;
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

    /**
     * @return AMemberProductInterface|AMemberParametersApiInterface
     */
    public function products(): AMemberProductInterface|AMemberParametersApiInterface;

    /**
     * @return AMemberRefundInterface|AMemberParametersApiInterface
     */
    public function refunds(): AMemberRefundInterface|AMemberParametersApiInterface;

    /**
     * @return AMemberFormInterface|AMemberParametersApiInterface
     */
    public function forms(): AMemberFormInterface|AMemberParametersApiInterface;

    /**
     * @return AMemberAccessInterface|AMemberParametersApiInterface
     */
    public function access(): AMemberAccessInterface|AMemberParametersApiInterface;

    /**
     * @return AMemberAffiliateInterface|AMemberParametersApiInterface
     */
    public function affiliate(): AMemberAffiliateInterface|AMemberParametersApiInterface;
}
