@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads.thread')

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="mt-3">
                    {{ $replies->links() }}
                </div>

                @if (auth()->check())
                    <div class="card mt-3">
                        <div class="card-body">
                            <form method="POST" action="{{ $thread->path() . '/replies' }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <textarea class="form-control" name="body" id="body" rows="5" placeholder="Have something to say?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Say</button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Thread meta</h4>
                    </div>
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="">{{ $thread->creator->name }}</a>, and currently
                        has {{ $thread->replies_count }} {{ \Str::plural('comment', $thread->replies_count) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
