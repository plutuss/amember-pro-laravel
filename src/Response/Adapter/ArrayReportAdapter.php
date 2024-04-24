<?php

namespace Plutuss\AMember\Response\Adapter;

class ArrayReportAdapter implements ReportAdapterInterface
{

    public function getData(int $status, mixed $data): array
    {
        return [
            'status' => $status,
            'data' => $data,
        ];
    }
}
