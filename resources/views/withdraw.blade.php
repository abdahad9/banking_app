@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Withdraw Money</div>

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
                            <form method="post" action="{{ route('withdraw') }}">
                                @csrf
                                <div class="form-group">
                                    Remaining Balance: {{ Auth::user()->balance }}
                                    <br>
                                    <label class="mt-3" for="amount">Amount:</label>
                                    <input type="number" class="form-control" id="amount" placeholder="Enter amount to Withdraw" name="amount" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">Withdraw</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
