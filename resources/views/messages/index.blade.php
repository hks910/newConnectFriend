@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Conversations</h1>
    <div class="list-group">
        @foreach ($friends as $user)
        <a href="{{ route('messages.chat', $user->id) }}" class="list-group-item list-group-item-action">
            Chat with {{ $user->name }}
        </a>
        @endforeach
    </div>
</div>
@endsection
