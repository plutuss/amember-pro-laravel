<?php

namespace Plutuss\AMember\Clients;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;


interface AMemberClientInterface
{

    /**
     * @param string $url
     * @param array $params
     * @return $this
     */
    public function setOption(string $url, array $params = []): static;

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendGet(): JsonResponse|array|Collection;

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendPost(): JsonResponse|array|Collection;

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendPut(): JsonResponse|array|Collection;

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendDelete(): JsonResponse|array|Collection;

}
