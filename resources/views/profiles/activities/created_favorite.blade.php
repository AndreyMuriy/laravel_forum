@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }}
        <a href="{{ $activity->subject->favorites->path() }}">
            favorited a reply.
        </a>
    @endslot
    @slot('body')
        {{ $activity->subject->favorites->body }}
    @endslot
@endcomponent
