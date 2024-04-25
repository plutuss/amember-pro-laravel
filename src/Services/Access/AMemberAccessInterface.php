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


    /**
     * @param array $data
     * @return JsonResponse|array|Collection
     */
    public function setAccess(array $data): JsonResponse|array|Collection;


    /**
     * @param int $id
     * @param array $data
     * @return JsonResponse|array|Collection
     */
    public function updateAccess(int $id, array $data): JsonResponse|array|Collection;
}
