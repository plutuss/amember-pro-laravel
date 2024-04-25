<?php

namespace Plutuss\AMember\Services\Access;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberAccessService extends AMemberClient implements AMemberAccessInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function getAccess(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/access', $id)
        )->sendGet();
    }


    /**
     * @param int|null $id
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function getAccessLog(?int $id = null): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/access-log', $id)
        )->sendGet();
    }

    /**
     * @param array $data
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function setAccess(array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/access'), $data
        )->sendPost();
    }

    /**
     * @param int $id
     * @param array $data
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function updateAccess(int $id, array $data): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/access', $id), $data
        )->sendPut();
    }
}
