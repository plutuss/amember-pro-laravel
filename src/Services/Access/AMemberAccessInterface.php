<?php

namespace Plutuss\AMember\Services\Access;

use Illuminate\Support\Collection;

interface AMemberAccessInterface
{
    /**
     * @param int|null $id
     * @return Collection
     */
    public function getAccess(?int $id = null): Collection;

    /**
     * @param int|null $id
     * @return Collection
     */
    public function getAccessLog(?int $id = null): Collection;
}
