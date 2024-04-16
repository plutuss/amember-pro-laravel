<?php

namespace Plutuss\AMember\Response\Adapter;

use Illuminate\Http\JsonResponse;

class JsonReportAdapter implements ReportAdapterInterface
{

    public function getData(int $status, mixed $data): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
        ]);
    }
}
