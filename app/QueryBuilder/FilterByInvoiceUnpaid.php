<?php
namespace App\QueryBuilder;

use Spatie\QueryBuilder\Includes\IncludeInterface;
use Illuminate\Database\Eloquent\Builder;

class FilterByInvoiceUnpaid implements IncludeInterface
{

    public function __construct()
    {
    }

    public function __invoke(Builder $query, string $relations)
    {
        // $query->withAggregate($relations, $this->column, $this->function);
        $query->whereDoesntHave($relations, function (Builder $query) {
            $query->where('status', '!=', 'paid');
        });
    }
}