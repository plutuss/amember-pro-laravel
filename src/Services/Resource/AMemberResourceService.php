<?php

namespace Plutuss\AMember\Services\Resource;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;

/** Read a documented REST resource, optionally selecting a record by ID. */
class AMemberResourceService extends AMemberClient
{
    public function __construct(private string $endpoint)
    {
        parent::__construct();
    }

    public function get(?int $id = null, array $params = []): JsonResponse|array|Collection
    {
        return $this->setOption(url_join($this->endpoint, $id), $params)->sendGet();
    }
}
