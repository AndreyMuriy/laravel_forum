@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('threads.thread')

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>

                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Thread meta</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="">{{ $thread->creator->name }}</a>, and currently
                                has <span
                                    v-text="repliesCount"></span> {{ \Str::plural('comment', $thread->replies_count) }}
                            </p>
                            <p>
                                <subscribe-button
                                    :active="{{ json_encode($thread->is_subscribed_to) }}"
                                    v-if="signedIn"></subscribe-button>

                                <button class="btn btn-secondary"
                                        v-if="authorize('isAdmin')"
                                        @click="toogleLock"
                                        v-text="locked ? 'Unlock' : 'Lock'"></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
