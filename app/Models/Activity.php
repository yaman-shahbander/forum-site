<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'subject_id', 'subject_type'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
