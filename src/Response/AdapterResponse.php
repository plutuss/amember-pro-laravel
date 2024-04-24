<?php

namespace Plutuss\AMember\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class AdapterResponse
{
    private string $type_response;
    private array $response_class;

    /**
     * @var null|static
     */
    private static $instance = null;

    public function __construct()
    {
        $this->type_response = config('amember.type_response.default');
        $this->response_class = config('amember.type_response.response_class');
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

    public function getResponse(int $status, mixed $data): array|JsonResponse|Collection
    {
        return match ($this->type_response) {
            'collection' => (new $this->response_class['collection'])->getData($status, $data),
            'array' => (new $this->response_class['array'])->getData($status, $data),
            'json' => (new $this->response_class['json'])->getData($status, $data),
            default => $data,
        };
    }
}
