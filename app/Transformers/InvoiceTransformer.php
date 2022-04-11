<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class InvoiceTransformer extends TransformerAbstract {
    public function transform($item)
    {
        return $item->toArray();
    }
}