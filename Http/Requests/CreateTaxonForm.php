<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreateTaxonForm as CreateTaxonFormContract;
use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Models\TaxonProxy;

class CreateTaxonForm extends FormRequest implements CreateTaxonFormContract
{
    /** @var Taxon|null|bool */
    protected $defaultParent = false;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'parent' => 'sometimes|exists:' . app(Taxon::class)->getTable() . ',id'
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultParent()
    {
        if ($id = $this->query('parent')) {
            return TaxonProxy::find($id);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getNextPriority(Taxon $taxon): int
    {
        // Workaround due to `neighbours` relation not working on root level taxons
        if ($taxon->isRootLevel()) {
            $lastNeighbour = TaxonProxy::byTaxonomy($taxon->taxonomy_id)->roots()->sortReverse()->first();
        } else {
            $lastNeighbour = $taxon->lastNeighbour();
        }

        return $lastNeighbour ? $lastNeighbour->priority + 10 : 10;
    }
}
