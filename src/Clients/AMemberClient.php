<?php

namespace Plutuss\AMember\Clients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;
use Plutuss\AMember\Traits\AMemberParametersApi;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AMemberClient implements AMemberClientInterface, AMemberParametersApiInterface
{
    use AMemberParametersApi;

    private string $amember_api_key;
    protected array $params;
    private string $url;
    private static $instance = null;


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
        $this->url = config('amember.amember_url') . $url;
        $this->params = $params;
        $this->amember_api_key = config('amember.amember_api_key');
        $this->initParams();

        return $this;
    }

    /**
     * @return Collection
     */
    public function sendGet(): Collection
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
     * @return Collection
     */
    public function sendPost(): Collection
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
     * @return Collection
     */
    public function sendPut(): Collection
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
     * @return Collection
     */
    public function sendDelete(): Collection
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
     * @return Collection
     */
    private function getResponse(int $status, mixed $data): Collection
    {
        return collect([
            'status' => $status,
            'data' => $data,
        ]);
    }
}
