<?php

namespace App\Filters;

use App\Models\User;
use App\Filters\Filters;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];
    /**
     * @param mixed $username
     * @return mixed
     */
    protected function by(string $username): mixed
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    protected function popular(): mixed
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
