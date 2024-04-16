<?php

namespace Plutuss\AMember\Response\Adapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface ReportAdapterInterface
{
    public function getData(int $status, mixed $data): array|JsonResponse|Collection;
}
