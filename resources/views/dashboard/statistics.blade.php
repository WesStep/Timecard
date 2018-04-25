@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Business Statistics</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <h3 class="mr-2">Quick Date Range:</h3>
            </div>
            <div class="col-md-8">
                <button class="btn btn-info" type="button" name="pastWeek">Past Week</button>
                <button class="btn btn-info" type="button" name="pastMonth">Past Month</button>
                <button class="btn btn-info" type="button" name="pastQuarter">Past Quarter</button>
                <button class="btn btn-info" type="button" name="pastYear">Past Year</button>
            </div>
        </div>
        <form class="row" action="index.html" method="post">
            <div class="col-md-4">
                <h3>or Select Date Range:</h3>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="datetime-local" name="startDate">
            </div>
            <div class="col-md-1">
                <h3 class="ml-2 mr-2">to</h3>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="datetime-local" name="endDate">
            </div>
            <div class="col-md-1">
                <button class="btn btn-success" type="submit" name="search">Go</button>
            </div>
        </form>
        <hr>
        <h1 class="text-center">Report:</h1>
        <div class="row mb-3">
            <div class="col-md">
                <ul class="nav nav-tabs">
                    @foreach($companies as $company)
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ $company->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <p><strong>Employee Name</strong></p>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md text-md-center">
                        <p><strong>Shifts Worked</strong></p>
                    </div>
                    <div class="col-md text-md-center">
                        <p><strong>Hours Worked</strong></p>
                    </div>
                    <div class="col-md text-md-center">
                        <p><strong>Wages Paid</strong></p>
                    </div>
                    <div class="col-md text-md-center">
                        <p><strong>Shift Details</strong></p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @foreach($users as $user)
            <div class="row">
                <div class="col-md-2">
                    <p><strong>{{ $user->name }}</strong></p>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md text-md-center">
                            <p>{{ 10 }}</p>
                        </div>
                        <div class="col-md text-md-center">
                            <p>{{ 20 }}</p>
                        </div>
                        <div class="col-md text-md-center">
                            <p>{{ '$999.99' }}</p>
                        </div>
                        <div class="col-md text-md-center">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" data-toggle="collapse" href="#collapseDetail{{ $user->id }}"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse row" id="collapseDetail{{ $user->id }}">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md">
                            <p><strong>Start Time</strong></p>
                        </div>
                        <div class="col-md">
                            <p><strong>End Time</strong></p>
                        </div>
                        <div class="col-md">
                            <p><strong>Duration</strong></p>
                        </div>
                        <div class="col-md">
                            <p><strong>Notes</strong></p>
                        </div>
                    </div>
                    <hr>
                    @foreach($shifts as $shift)
                        // MAKE THIS SECTION WORK
                    @endforeach
                </div>
            </div>
        <hr>
    @endforeach
    </div>
@endsection
