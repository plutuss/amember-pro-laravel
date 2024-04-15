<?php

namespace Plutuss\AMember\Services\Product;

use Illuminate\Support\Collection;

interface AMemberProductInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function products(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function billingPlans(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function productCategory(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function productCategoryRelations(int $id = null): Collection;


}
