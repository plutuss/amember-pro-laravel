<?php

namespace Plutuss\AMember\Services\Form;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface AMemberFormInterface
{

    /**
     * @return JsonResponse|array|Collection
     */
    public function savedForms(): JsonResponse|array|Collection;
}
