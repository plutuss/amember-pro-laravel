<?php

namespace Plutuss\AMember\Response\Adapter;

use Illuminate\Support\Collection;

class CollectionReportAdapter implements ReportAdapterInterface
{

    public function getData(int $status, mixed $data): Collection
    {
        return collect([
            'status' => $status,
            'data' => $data,
        ]);
    }
}
