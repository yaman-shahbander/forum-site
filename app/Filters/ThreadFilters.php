<?php

namespace App\Filters;

use App\Models\User;
use App\Filters\Filters;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];
    /**
     * @param mixed $username
     * @return mixed
     */
    protected function by(string $username): mixed
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
