<?php

namespace Modules\Shop\Contracts\Requests;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Contracts\BaseRequest;

interface SyncModelTaxons extends BaseRequest
{
    /**
     * Returns the model taxons need to be synchronized for
     *
     * @return null|Model
     */
    public function getFor();

    public function getTaxonIds(): array;
}
