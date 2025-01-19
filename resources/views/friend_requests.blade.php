@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Friend Requests</h1>

    <div class="row">
        @foreach ($friends as $friend)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $friend->sender->name }}</h5>
                    <p class="card-text">{{ $friend->sender->field_of_work }}</p>
                    <form action="{{ route('friend.accept', $friend->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>
                    <form action="{{ route('friend.decline', $friend->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $friends->links() }}
    </div>
</div>
@endsection
