@forelse($threads as $thread)
    <article class="mb-4">
        <div class="card">
            <div class="card-header">
                <div class="level">
                    <div class="flex">
                        <h5>
                            <a href="{{ $thread->path() }}">
                                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                    <strong>{{ $thread->title }}</strong>
                                @else
                                    {{ $thread->title }}
                                @endif
                            </a>
                        </h5>

                        <h6>
                            Posted By: <a
                                href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                        </h6>
                    </div>

                    <strong>{{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}</strong>
                </div>
            </div>

            <div class="card-body">
                <div class="body"> {{ $thread->body }}</div>
            </div>

            <div class="card-footer">
                {{ $thread->visits }} visits.
            </div>
        </div>
    </article>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse
