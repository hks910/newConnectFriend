@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Friends</h1>
    <div class="row mb-4">
        <!-- Search and Filter Section -->
        <div class="col-md-6">
            <form method="GET" action="{{ route('friends') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('friends') }}">
                <div class="input-group">
                    <select name="field_of_work" class="form-select">
                        <option value="">Filter by Field of Work</option>
                        @foreach($fields as $field)
                            <option value="{{ $field }}" {{ request('field_of_work') == $field ? 'selected' : '' }}>{{ $field }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-primary" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach ($users as $user)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">Field of Work: {{ $user->field_of_work }}</p>
                    @if (!in_array($user->id, $thumbedUsers))
                        <form action="{{ route('friends.giveThumb', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Give Thumb</button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>Thumb Given</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
@endsection
