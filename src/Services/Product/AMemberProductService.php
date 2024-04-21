<?php

namespace Plutuss\AMember\Services\Product;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberProductService extends AMemberClient implements AMemberProductInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function products(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/products', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function billingPlans(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/billing-plans', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function productCategoryRelations(int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/product-product-category', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function productCategory(int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/product-category', $id)
        )->sendGet();
    }


    /**
     * @param array $data
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function setProducts(array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/products'), $data
        )->sendPost();
    }

    /**
     * @param int $id
     * @param array $data
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function updateProducts(int $id, array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/products', $id), $data
        )->sendPut();
    }
}
