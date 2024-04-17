<?php

namespace Plutuss\AMember\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class AdapterResponse
{
    private string $type_response;
    private array $response_class;

    public function __construct()
    {
        $this->type_response = config('amember.type_response.default');
        $this->response_class = config('amember.type_response.response_class');
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
