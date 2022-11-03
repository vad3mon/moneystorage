<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public $collects = Transaction::class;

    public function toArray($request)
    {

        $dates = $this->collection->groupBy('date')
            ->map(function ($item) {
                return ['sum' => $item->sum('sum'),
                        'data' => $item];
            });

        return $dates;
    }
}
