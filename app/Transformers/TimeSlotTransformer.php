<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TimeSlotTransformer extends TransformerAbstract {
    public function transform($item)
    {
        return $item->toArray();
    }
}