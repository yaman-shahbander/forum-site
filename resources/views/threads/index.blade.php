@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($threads as $thread)
                <div class="card mb-10">
                    <div class="card-header">
                        <div class="level">
                            <h4 class="flex">
                                <a href="/threads/{{$thread->channel->slug}}/{{ $thread->id }}">{{ $thread->title }}</a>
                            </h4>
                            <a href="{{ $thread->path() }}">
                                {{ $thread->replies_count }} {{ Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>{{ $thread->body }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
