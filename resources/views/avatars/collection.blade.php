@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Avatar Collection</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach ($avatars as $avatar)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset( $avatar->avatar->avatar_image) }}" class="card-img-top" alt="Avatar">
                    <div class="card-body">
                        <h5 class="card-title">{{ $avatar->avatar->avatar_name }}</h5>
                        <p class="card-text">{{ $avatar->avatar->avatar_price }} Coins</p>

                        @if ($avatar->avatar_id == Auth::user()->avatar_id)
                            <button class="btn btn-secondary" disabled>Main Avatar</button>
                        @else
                            <form action="{{ route('avatars.setMain', $avatar->avatar_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Set as Main Avatar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
