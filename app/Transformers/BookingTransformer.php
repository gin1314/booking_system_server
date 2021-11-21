<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BookingTransformer extends TransformerAbstract
{
    public function transform($item)
    {
        return $item->toArray();
    }
}
