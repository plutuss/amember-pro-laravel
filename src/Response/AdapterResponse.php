<?php

namespace Plutuss\AMember\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Response\Adapter\ArrayReportAdapter;
use Plutuss\AMember\Response\Adapter\CollectionReportAdapter;
use Plutuss\AMember\Response\Adapter\JsonReportAdapter;
use Plutuss\AMember\Response\Adapter\ReportAdapterInterface;

class AdapterResponse
{
    private string $type_response;

    public function __construct()
    {
        $this->type_response = config('amember.type_response.default');
    }

    public function getResponse(int $status, mixed $data): array|JsonResponse|Collection
    {
        return match ($this->type_response) {
            'collection' => (new CollectionReportAdapter)->getData($status, $data),
            'array' => (new ArrayReportAdapter)->getData($status, $data),
            'json' => (new JsonReportAdapter)->getData($status, $data),
            default => $data,
        };
    }
}
