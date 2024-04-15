<?php

namespace Plutuss\AMember\Clients;

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
     * @return Collection
     */
    public function sendGet(): Collection;

    /**
     * @return Collection
     */
    public function sendPost(): Collection;

    /**
     * @return Collection
     */
    public function sendPut(): Collection;

    /**
     * @return Collection
     */
    public function sendDelete(): Collection;

}
