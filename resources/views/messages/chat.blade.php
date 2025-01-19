@extends('layouts.app')

@section('content')
<style>
    .messages div.text-right {
        text-align: right;
        margin-left: 50%;
    }
    .messages div.text-left {
        text-align: left;
        margin-right: 50%;
    }
    </style>
    
<div class="container">
    <h1>Chat with {{ $friend->name }}</h1> <!-- Assuming you pass $friend from the controller -->
    <div class="card">
        <div class="card-body">
            <div class="messages" style="height: 400px; overflow-y: scroll;">
                @foreach ($messages as $message)
                <div class="{{ $message->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                    <strong>{{ $message->sender_id == Auth::id() ? 'You' : $message->sender->name }}</strong>
                    <p>{{ $message->message }}</p>
                    <small>{{ $message->created_at->diffForHumans() }}</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <form action="{{ route('messages.send', $friend->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
</div>
@endsection

