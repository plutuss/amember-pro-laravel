<?php

namespace Plutuss\AMember\Services;

use Plutuss\AMember\Contracts\AMemberInterface;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;
use Plutuss\AMember\Services\Access\AMemberAccessInterface;
use Plutuss\AMember\Services\Access\AMemberAccessService;
use Plutuss\AMember\Services\Affiliate\AMemberAffiliateInterface;
use Plutuss\AMember\Services\Affiliate\AMemberAffiliateService;
use Plutuss\AMember\Services\Auth\AMemberCheckAccessInterface;
use Plutuss\AMember\Services\Auth\AMemberCheckAccessService;
use Plutuss\AMember\Services\Form\AMemberFormInterface;
use Plutuss\AMember\Services\Form\AMemberFormService;
use Plutuss\AMember\Services\Invoice\AMemberInvoiceInterface;
use Plutuss\AMember\Services\Invoice\AMemberInvoiceService;
use Plutuss\AMember\Services\Payment\AMemberPaymentInterface;
use Plutuss\AMember\Services\Payment\AMemberPaymentService;
use Plutuss\AMember\Services\Product\AMemberProductInterface;
use Plutuss\AMember\Services\Product\AMemberProductService;
use Plutuss\AMember\Services\Refund\AMemberRefundInterface;
use Plutuss\AMember\Services\Refund\AMemberRefundService;
use Plutuss\AMember\Services\Users\AMemberUserInterface;
use Plutuss\AMember\Services\Users\AMemberUserService;

class AMemberService implements AMemberInterface
{
    /**
     * @return AMemberCheckAccessInterface|AMemberParametersApiInterface
     */
    public function auth(): AMemberCheckAccessInterface|AMemberParametersApiInterface
    {
        return AMemberCheckAccessService::getInstance();
    }

    /**
     * @return AMemberParametersApiInterface|AMemberInvoiceInterface
     */
    public function invoice(): AMemberParametersApiInterface|AMemberInvoiceInterface
    {
        return AMemberInvoiceService::getInstance();
    }

    /**
     * @return AMemberPaymentInterface|AMemberParametersApiInterface
     */
    public function payment(): AMemberPaymentInterface|AMemberParametersApiInterface
    {
        return AMemberPaymentService::getInstance();
    }

    /**
     * @return AMemberUserInterface|AMemberParametersApiInterface
     */
    public function users(): AMemberUserInterface|AMemberParametersApiInterface
    {
        return AMemberUserService::getInstance();
    }

    /**
     * @return AMemberProductInterface|AMemberParametersApiInterface
     */
    public function products(): AMemberProductInterface|AMemberParametersApiInterface
    {
        return AMemberProductService::getInstance();
    }

    /**
     * @return AMemberRefundInterface|AMemberParametersApiInterface
     */
    public function refunds(): AMemberRefundInterface|AMemberParametersApiInterface
    {
        return AMemberRefundService::getInstance();
    }

    /**
     * @return AMemberFormInterface|AMemberParametersApiInterface
     */
    public function forms(): AMemberFormInterface|AMemberParametersApiInterface
    {
        return AMemberFormService::getInstance();
    }

    /**
     * @return AMemberAccessInterface|AMemberParametersApiInterface
     */
    public function access(): AMemberAccessInterface|AMemberParametersApiInterface
    {
        return AMemberAccessService::getInstance();
    }

    /**
     * @return AMemberAffiliateInterface|AMemberParametersApiInterface
     */
    public function affiliate(): AMemberAffiliateInterface|AMemberParametersApiInterface
    {
        return AMemberAffiliateService::getInstance();
    }

}
