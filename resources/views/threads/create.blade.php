@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>
                    <div class="card-body">
                        <form method="POST" action="/threads">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Choose a channel:</label>
                                <select class="form-control" id="channel" name="channel_id" required>
                                    <option value="">Choose one...</option>
                                    @foreach(App\Models\Channel::all() as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" />
                            </div>
                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea type="text" class="form-control" id="body" rows="8" name="body">{{ old('body') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="margin-top: 10px">Publish</button>
                            @if(count($errors))
                                <ul class="alert alert-danger" style="margin-top: 10px">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
