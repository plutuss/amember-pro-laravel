<?php

namespace Plutuss\AMember\Services\Form;

use Illuminate\Support\Collection;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Contracts\AMemberParametersApiInterface;

class AMemberFormService extends AMemberClient implements AMemberFormInterface, AMemberParametersApiInterface
{

    /**
     * @return Collection
     */
    public function savedForms(): Collection
    {
        return $this->setOption(
            url_join('/saved-forms')
        )->sendGet();
    }
}
