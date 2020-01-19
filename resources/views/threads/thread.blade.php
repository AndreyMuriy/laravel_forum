<div class="card mt-3 mb-3">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                <a href="{{ route('profile', $thread->creator->name) }}">
                    {{ $thread->creator->name }}
                </a> posted:
            <span>{{ $thread->created_at->diffForHumans() }}</span>
            </span>

            @auth()
                @if (auth()->id() == $thread->creator->id)
                    <div>
                        <form method="POST" action="{{ $thread->path() }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">Delete</button>
                        </form>
                    </div>
                @endif
            @endauth

        </div>
        <h4>{{ $thread->title }}</h4>
    </div>
    <div class="card-body">
        <p>{{ $thread->body }}</p>
    </div>
</div>
