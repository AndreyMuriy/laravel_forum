@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
            <h1>
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        @foreach($threads as $thread)
            <div class="card mt-3 mb-3">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="#">{{ $thread->creator->name }} posted:</a>
                            {{ $thread->title }}
                        </span>

                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                    <h4>{{ $thread->title }}</h4>
                </div>
                <div class="card-body">
                    <p>{{ $thread->body }}</p>
                </div>
            </div>
        @endforeach

        {{ $threads->links()  }}
    </div>
@endsection
