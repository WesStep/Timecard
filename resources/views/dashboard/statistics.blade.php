@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Business Statistics</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row mb-4">
            @if(Session::has('info'))
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
            @endif
            <div class="col-md-3">
                <h3 class="text-md-right">Quick Date:</h3>
            </div>
            <div class="col-md-9">
                <form action="{{ route('dashboard/statistics/show') }}" method="get">
                    @csrf
                    <div class="form-check form-check-inline">
                        <label class="radio-container" for="week">Past Week
                            <input class="form-check-input" type="radio" name="length" id="week" value="week" checked>
                            <span class="radio-checkmark"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="radio-container" for="month">Past Month
                            <input class="form-check-input" type="radio" name="length" id="month" value="month">
                            <span class="radio-checkmark"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="radio-container" for="quarter">Past Quarter
                            <input class="form-check-input" type="radio" name="length" id="quarter" value="quarter">
                            <span class="radio-checkmark"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="radio-container" for="year">Past Year
                            <input class="form-check-input" type="radio" name="length" id="year" value="year">
                            <span class="radio-checkmark"></span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-info" name="getStats">Go</button>
                </form>
            </div>
        </div>
        <form class="row" action="{{ route('dashboard/statistics/show') }}" method="get">
            <input type="hidden" name="length" value="custom">
            <div class="col-md-3">
                <h3 conditionclass="text-md-right">or Select Date:</h3>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="startDate" required>
            </div>
            <div class="col-md-1">
                <h3 class="text-md-center">to</h3>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="endDate" required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-info" type="submit" name="getStats">Go</button>
            </div>
        </form>
        <hr>
        <h3 class="text-md-center">Report</h3>
        <hr>
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
        @foreach($employees as $employee)
            <div class="row">
                <div class="col-md-2">
                    <p><strong>{{ $employee->name }}</strong></p>
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
                                <button class="btn btn-info dropdown-toggle" data-toggle="collapse" href="#collapseDetail{{ $employee->id }}"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse row" id="collapseDetail{{ $employee->id }}">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md text-md-right">
                            <p><strong>Company</strong></p>
                        </div>
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
                    @isset($companies)
                        @foreach($companies as $company)
                            <hr>
                            <div class="row">
                                <div class="col-md text-md-right">
                                    <p><strong>{{ $company->name }}</strong></p>
                                </div>
                                <div class="col-md">
                                </div>
                                <div class="col-md">
                                </div>
                                <div class="col-md">
                                </div>
                                <div class="col-md">
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
            <hr>
        @endforeach
    </div>
@endsection
