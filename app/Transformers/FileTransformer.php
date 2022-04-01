<?php

namespace App\Transformers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract {
    public function transform($item)
    {
        // $data = $item->toArray();

        // $timezone = request()->header('X-Local-Timezone') ?? 'UTC';
        // if (!isDateInZeroFmt($item->createdAt)) {
        //     $createdAt =  Carbon::createFromFormat('Y-m-d H:i:s', $item->createdAt, 'UTC');
        //     $ca = $createdAt->setTimezone($timezone)->format('Y-m-d H:i:s');
        //     Arr::set($data, 'createdAt', $ca);
        // }
        return $item->toArray();
    }
}