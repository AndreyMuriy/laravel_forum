@extends('layouts.app')

@section('content')
    <thread-view :data="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('threads.thread')

                    <replies :data="{{ $thread->replies }}"
                             @added="repliesCount++"
                             @removed="repliesCount--">
                    </replies>

                    <div class="mt-3">
                        {{ $replies->links() }}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Thread meta</h4>
                        </div>
                        <div class="card-body">
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="">{{ $thread->creator->name }}</a>, and currently
                            has <span v-text="repliesCount"></span> {{ \Str::plural('comment', $thread->replies_count) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
