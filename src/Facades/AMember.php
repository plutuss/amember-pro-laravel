<?php

namespace Plutuss\AMember\Facades;

use Plutuss\AMember\Services\Resource\AMemberResourceService;

use Illuminate\Support\Facades\Facade;
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


/**
 * @method static AMemberResourceService userGroups()
 * @method static AMemberResourceService userNotes()
 * @method static AMemberResourceService userConsent()
 * @method static AMemberResourceService billingPlans()
 * @method static AMemberResourceService productCategories()
 * @method static AMemberResourceService productCategoryRelations()
 * @method static AMemberResourceService invoiceItems()
 * @method static AMemberCheckAccessInterface|AMemberParametersApiInterface auth()
 * @method static AMemberParametersApiInterface|AMemberInvoiceInterface invoice()
 * @method static AMemberPaymentInterface|AMemberParametersApiInterface payment()
 * @method static AMemberUserInterface|AMemberParametersApiInterface users()
 * @method static AMemberProductInterface|AMemberParametersApiInterface products()
 * @method static AMemberRefundInterface|AMemberParametersApiInterface refunds()
 * @method static AMemberFormInterface|AMemberParametersApiInterface forms()
 * @method static AMemberAccessInterface|AMemberParametersApiInterface access()
 * @method static AMemberAffiliateInterface|AMemberParametersApiInterface affiliate()
 *
 *
 *
 * @see \Plutuss\AMember\Contracts\AMemberInterface
 */
class AMember extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'amember.app';
    }

}
