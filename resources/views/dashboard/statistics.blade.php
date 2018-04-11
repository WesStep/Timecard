@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Business Statistics</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="btn-group" role="group" aria-label="Time Periods">
                <button type="button" class="btn btn-info" onclick="{{ route('dashboard/statistics/week') }}">Last Week</button>
                <button type="button" class="btn btn-info" onclick="{{ route('dashboard/statistics/month') }}">Last Month</button>
                <button type="button" class="btn btn-info" onclick="{{ route('dashboard/statistics/year') }}">Last Year</button>
            </div>
        </div>
        <div class="row">
            <h1>Week of the {{ $weekAgo->format('jS') }} through the {{ $today->format('jS') }}</h1>
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
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">Notes</button>
                            <div class="dropdown-menu">
                                <div class="dropdown-item">
                                    <hr>
                                    <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, adipisci amet blanditiis dolores ea eveniet illo ipsa itaque magni maiores non odit praesentium, quae sequi sit soluta sunt! Expedita, ipsam?</span></p>
                                </div>
                                <div class="dropdown-item">
                                    <hr>
                                    <p>example note</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        @endforeach
    </div>
@endsection
