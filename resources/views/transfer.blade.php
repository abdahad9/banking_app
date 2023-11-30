@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Transfer Money</div>

                <div class="card-body">
                        <div class="col-md-8 offset-md-3">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form method="post" action="{{ route('transfer') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="recipient">Select Recipient:</label>
                                <select class="form-control" id="recipient" name="recipient" required>
                                        <option value="" selected disabled>Please select user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Transfer</button>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
