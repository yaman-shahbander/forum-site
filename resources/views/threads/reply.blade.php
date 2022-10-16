<div class="card mb-10">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#">{{ $reply->owner->name }}</a>
                said {{ $reply->created_at->diffForHumans() }}...
            </h5>
            <div>
                <form method="POST" action="{{ route('favorites.reply', ['reply' => $reply->id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites()->count() }} {{ Illuminate\Support\Str::plural('favorite', $reply->favorites()->count()) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
