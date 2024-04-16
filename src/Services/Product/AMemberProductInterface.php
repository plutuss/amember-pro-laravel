<?php

namespace Plutuss\AMember\Services\Product;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberProductInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function products(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function billingPlans(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function productCategory(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function productCategoryRelations(int $id = null): JsonResponse|array|Collection;


}
