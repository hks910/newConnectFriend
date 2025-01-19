@extends('layouts.app')



@section('content')
<div class="container">
    <h1>Avatars</h1>
    <div class="row">
        @foreach ($avatars as $avatar)
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="{{ asset( $avatar->avatar_image) }}" class="card-img-top" alt="Avatar">
                <div class="card-body">
                    <h5 class="card-title">{{ $avatar->avatar_name }}</h5>
                    <p class="card-text">{{ $avatar->avatar_price }} Coins</p>

                    @php
                        $alreadyBought = \App\Models\AvatarCollection::where('sender_id', Auth::id())
                                                                    ->where('avatar_id', $avatar->id)
                                                                    ->exists();
                    @endphp

                    @if ($alreadyBought)
                        <button class="btn btn-secondary" disabled>Purchased</button>
                    @else
                        <form action="{{ route('avatars.buy', $avatar->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Buy</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

