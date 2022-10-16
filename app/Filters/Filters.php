<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $builder;
    protected $filters = [];

    public function __construct(protected Request $request)
    {
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) $this->$filter($value);
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
