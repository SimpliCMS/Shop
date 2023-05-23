<?php

namespace Modules\Shop\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;
use Vanilo\Category\Contracts\Taxon;

interface CreateTaxonForm extends BaseRequest
{
    /**
     * Returns the Taxon the new taxon should be the child of
     *
     * @return null|Taxon
     */
    public function getDefaultParent();

    /**
     * Returns the proposed priority value for a new taxon
     * @param Taxon $taxon
     * @return int
     */
    public function getNextPriority(Taxon $taxon): int;
}
