@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Business Statistics</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h1>For the Week of the {{ $weekAgo->format('jS') }} through the {{ $today->format('jS') }}</h1>
        </div>
        <div class="row">
            <div class="col-md"></div>
            @foreach($companies as $company)
                <div class="col-md"><p><strong>{{ $company->name }}</strong></p></div>
            @endforeach
        </div>
        <hr>
        @foreach($users as $user)
        <div class="row">
            <div class="col-md text-md-right">
                <p><strong>{{ $user->name }} ID: {{ $user->id }}</strong></p>
            </div>
            @foreach($companies as $company)
                <div class="col-md">
                    <div class="row">
                        <p>Hours worked:</p>
                    </div>

                    <div class="row">
                        <p>Notes:</p>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        @endforeach
    </div>
@endsection
