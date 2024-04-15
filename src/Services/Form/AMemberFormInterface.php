<?php

namespace Plutuss\AMember\Services\Form;

use Illuminate\Support\Collection;

interface AMemberFormInterface
{

    /**
     * @return Collection
     */
    public function savedForms(): Collection;
}
