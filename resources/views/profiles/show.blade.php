@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="pb-2 mt-4 mb-2 border-bottom">
            {{ $profileUser->name }}
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>

        @forelse($activities as $date => $activitySet)
            <h3 class="pb-2 mt-4 mb-2 border-bottom">
                {{ $date }}
            </h3>
            @foreach($activitySet as $activity)
                @if (view()->exists("profiles.activities.{$activity->type}"))
                    @include("profiles.activities.{$activity->type}")
                @endif
            @endforeach
        @empty
            <p>There is no activity for this user yet.</p>
        @endforelse
    </div>
@endsection
