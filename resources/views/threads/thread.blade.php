<div class="card mt-3 mb-3">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                <a href="{{ route('profile', $thread->creator->name) }}">
                    {{ $thread->creator->name }}
                </a> posted:
            </span>

            <span>{{ $thread->created_at->diffForHumans() }}</span>
        </div>
        <h4>{{ $thread->title }}</h4>
    </div>
    <div class="card-body">
        <p>{{ $thread->body }}</p>
    </div>
</div>
