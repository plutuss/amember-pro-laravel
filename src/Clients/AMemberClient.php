<?php

namespace Plutuss\AMember\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;
use Plutuss\AMember\Response\AdapterResponse;
use Plutuss\AMember\Traits\AMemberParametersApi;

class AMemberClient implements AMemberClientInterface, AMemberParametersApiInterface
{
    use AMemberParametersApi;

    /**
     * @var string
     */
    private string $amember_api_key;

    /**
     * @var array
     */
    protected array $params = [];

    /**
     * @var string
     */
    private string $url;

    private string $baseUrl;

    /**
     * @var null|static
     */
    private static $instance = null;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('amember.amember_url'), '/');
        $this->url = $this->baseUrl;
        $this->amember_api_key = config('amember.amember_api_key');
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        if (!(static::$instance instanceof static)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param string $url
     * @param array $params
     * @return $this
     */
    public function setOption(string $url, array $params = []): static
    {
        $this->url = $this->baseUrl . '/' . ltrim($url, '/');
        $this->params = $params;

        return $this;
    }

    /**
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function sendGet(): JsonResponse|array|Collection
    {
        return $this->sendRequest('get');
    }

    /**
     * @throws ConnectionException
     */
    public function sendPost(): JsonResponse|array|Collection
    {
        return $this->sendRequest('post');
    }

    /**
     * @throws ConnectionException
     */
    public function sendPut(): JsonResponse|array|Collection
    {
        return $this->sendRequest('put');
    }

    /**
     * @throws ConnectionException
     */
    public function sendDelete(): JsonResponse|array|Collection
    {
        return $this->sendRequest('delete');
    }

    private function sendRequest(string $method): JsonResponse|array|Collection
    {
        $this->initParams();

        $request = Http::withHeaders([
            'X-API-Key' => $this->amember_api_key,
        ]);

        if (in_array($method, ['post', 'put'], true)) {
            $request = $request->asForm();
        }

        $response = $request->{$method}($this->url, $this->params);

        return $this->getResponse($response->status(), $response->json());
    }

    /**
     * @param int $status
     * @param mixed $data
     * @return JsonResponse|array|Collection
     */
    private function getResponse(int $status, mixed $data): JsonResponse|array|Collection
    {
        return AdapterResponse::getInstance()->getResponse($status, $data);
    }

}
