<?php
namespace App\QueryBuilder;

use Spatie\QueryBuilder\Includes\IncludeInterface;
use Illuminate\Database\Eloquent\Builder;

class FilterByInvoiceStatus implements IncludeInterface
{
    protected string $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function __invoke(Builder $query, string $relations)
    {
        // $query->withAggregate($relations, $this->column, $this->function);
        $query->whereHas($relations, function (Builder $query) {
            $query->where('status', $this->status);
        });
    }
}