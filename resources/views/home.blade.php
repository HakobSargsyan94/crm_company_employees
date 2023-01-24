@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                @guest
                    <h3 class="m-3">Please login for to do something</h3>
                @else
                    <h3 class="m-3">You are logged in</h3>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
