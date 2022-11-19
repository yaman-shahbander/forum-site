<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Favoritable;

class Reply extends Model
{
    use HasFactory, Favoritable, RecordsActivity;

    protected $fillable = ['thread_id', 'user_id', 'body'];

    protected $with = ['owner', 'favorites'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
