<?php

namespace Plutuss\AMember\Services\Access;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberAccessService extends AMemberClient implements AMemberAccessInterface, AMemberParametersApiInterface
{

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getAccess(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/access', $id)
        )->sendGet();
    }

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getAccessLog(?int $id = null): Collection
    {
        return $this->setOption(
            url_join('/access-log', $id)
        )->sendGet();
    }
}
