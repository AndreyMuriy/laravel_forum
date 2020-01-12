@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>

                    <div class="card-footer">
                        Posted {{ $thread->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if (auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
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
                </div>
            </div>
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
        @endif

    </div>
@endsection
