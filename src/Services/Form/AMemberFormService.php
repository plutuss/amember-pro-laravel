<?php

namespace Plutuss\AMember\Services\Form;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberFormService extends AMemberClient implements AMemberFormInterface, AMemberParametersApiInterface
{

    /**
     * @return JsonResponse|array|Collection
     */
    public function savedForms(): JsonResponse|array|Collection
    {
        return $this->setOption(
            url_join('/saved-forms')
        )->sendGet();
    }
}
