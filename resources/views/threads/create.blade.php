@extends('layouts.app')

@section('head')
    <script src="https://www.google.com/recaptcha/api.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        <form id="create-thread-form" method="POST" action="{!! '/threads' !!}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel_id">Channel {{ old('channel_id') }}</label>
                                <select class="form-control" name="channel_id" id="channel_id">
                                    <option>Choose a channel...</option>
                                    @foreach($channels as $channel)
                                        <option
                                            {{ $channel->id == old('channel_id') ? 'selected' : '' }} value="{{ $channel->id }}">
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" name="body" id="body"
                                          rows="8">{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary g-recaptcha"
                                        data-sitekey="6LfhK6oZAAAAAKQ0IW3hu2Jos88ETRZX5wo3IzII"
                                        data-callback="onSubmit"
                                        data-action="submit">Publish</button>
                            </div>

                            @if (count($errors))
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li><strong>{{ $error }}</strong></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function onSubmit(token) {
            document.getElementById("create-thread-form").submit();
        }
    </script>
@endsection
