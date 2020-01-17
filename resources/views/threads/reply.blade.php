<div class="card mt-3">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile', $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}...
            </h5>
            @if (auth()->check())
                <div>
                    <form method="POST" action="{{ '/replies/' . $reply->id . '/favorites' }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-outline-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
            @else
                <span class="badge badge-primary">
                    {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                </span>
            @endif
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
