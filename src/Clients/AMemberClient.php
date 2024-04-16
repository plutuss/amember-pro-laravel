<?php

namespace Plutuss\AMember\Clients;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;
use Plutuss\AMember\Response\AdapterResponse;
use Plutuss\AMember\Traits\AMemberParametersApi;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AMemberClient implements AMemberClientInterface, AMemberParametersApiInterface
{
    use AMemberParametersApi;

    private string $amember_api_key;
    protected array $params;
    private string $url;
    private static $instance = null;

    public function __construct()
    {
        $this->url = config('amember.amember_url');
        $this->amember_api_key = config('amember.amember_api_key');
    }

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
        $this->url .= $url;
        $this->params = $params;
        $this->initParams();

        return $this;
    }

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendGet(): JsonResponse|array|Collection
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->amember_api_key,
            ])->get($this->url, $this->params);
        } catch (HttpException $exception) {
            throw new HttpException(500, $exception->getMessage());
        }

        return $this->getResponse($response->status(), $response->json());
    }

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendPost(): JsonResponse|array|Collection
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->amember_api_key,
            ])->asForm()->post($this->url, $this->params);
        } catch (HttpException $exception) {
            throw new HttpException(500, $exception->getMessage());
        }

        return $this->getResponse($response->status(), $response->json());
    }

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendPut(): JsonResponse|array|Collection
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->amember_api_key,
            ])->asForm()->put($this->url, $this->params);
        } catch (HttpException $exception) {
            throw new HttpException(500, $exception->getMessage());
        }

        return $this->getResponse($response->status(), $response->json());
    }

    /**
     * @return JsonResponse|array|Collection
     */
    public function sendDelete(): JsonResponse|array|Collection
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->amember_api_key,
            ])->delete($this->url, $this->params);
        } catch (HttpException $exception) {
            throw new HttpException(500, $exception->getMessage());
        }

        return $this->getResponse($response->status(), $response->json());
    }


    private function getResponse(int $status, mixed $data): JsonResponse|array|Collection
    {
        return (new AdapterResponse)->getResponse($status, $data);
    }
}
