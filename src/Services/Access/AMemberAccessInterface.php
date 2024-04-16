<?php

namespace Plutuss\AMember\Services\Access;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberAccessInterface
{
    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getAccess(?int $id = null): JsonResponse|array|Collection;

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     */
    public function getAccessLog(?int $id = null): JsonResponse|array|Collection;
}
