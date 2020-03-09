@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        @forelse($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex">
                                        <a href="{{ $thread->path() }}">
                                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                                <strong>{{ $thread->title }}</strong>
                                            @else
                                                {{ $thread->title }}
                                            @endif
                                        </a>
                                    </h4>
                                    <strong>{{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}</strong>
                                </div>
                                <div class="body"> {{ $thread->body }}</div>
                            </article>
                            <hr/>
                        @empty
                            <p>There are no relevant results at this time.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
