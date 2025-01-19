@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Complete Your Registration Payment') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('process_payment') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="payment_amount" class="col-md-4 col-form-label text-md-end">{{ __('Payment Amount') }}</label>
                            <div class="col-md-6">
                                <input id="payment_amount" type="number" class="form-control @error('payment_amount') is-invalid @enderror" name="payment_amount" required autocomplete="payment_amount">
                                @error('payment_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit Payment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
