<?php

namespace Plutuss\AMember\Clients;

use Illuminate\Http\Client\ConnectionException;
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

    /**
     * @var string
     */
    private string $amember_api_key;

    /**
     * @var array
     */
    protected array $params;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var null|static
     */
    private static $instance = null;

    public function __construct()
    {
        $this->url = config('amember.amember_url');
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
        $this->url .= $url;
        $this->params = $params;
        $this->initParams();

        return $this;
    }

    /**
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
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
     * @throws ConnectionException
     */
    public function sendPost(): JsonResponse|array|Collection
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->amember_api_key,
            ])
                ->asForm()
                ->post($this->url, $this->params);
        } catch (HttpException $exception) {
            throw new HttpException(500, $exception->getMessage());
        }

        return $this->getResponse($response->status(), $response->json());
    }


    /**
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
     */
    public function sendPut(): JsonResponse|array|Collection
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->amember_api_key,
            ])
                ->asForm()
                ->put($this->url, $this->params);
        } catch (HttpException $exception) {
            throw new HttpException(500, $exception->getMessage());
        }

        return $this->getResponse($response->status(), $response->json());
    }


    /**
     * @return JsonResponse|array|Collection
     * @throws ConnectionException
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
