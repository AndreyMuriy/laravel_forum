@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }}
        <a href="{{ $activity->subject->favorited->path() }}">
            favorited a reply.
        </a>
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
