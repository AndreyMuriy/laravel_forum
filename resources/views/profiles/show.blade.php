@extends('layouts.app')

@section('content')
    <div class="container">
        <avatar-form :user="{{ $profileUser }}"></avatar-form>

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
