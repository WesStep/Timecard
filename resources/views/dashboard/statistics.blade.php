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
                <h3 class="text-md-right">or Select Date:</h3>
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
        @isset($shifts)
            <hr>
            <h3 class="text-md-center">Report for {{ $startDate->format('j M Y') }} through {{ $endDate->format('j M Y') }}</h3>
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
                            <p><strong>Time Worked</strong></p>
                        </div>
                        <div class="col-md text-md-center">
                            <p><strong>Wages</strong></p>
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
                                <p>
                                    @if(array_key_exists($employee->name, $totalShiftsPerEmployee))
                                        {{ $totalShiftsPerEmployee[$employee->name] }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md text-md-center">
                                <p>
                                    @if(array_key_exists($employee->name, $totalMinutesPerEmployee))
                                        {{ floor(round($totalMinutesPerEmployee[$employee->name] / 60, 2)) }} hours, {{ $totalMinutesPerEmployee[$employee->name] % 60 }} minutes
                                    @endif
                                </p>
                            </div>
                            <div class="col-md text-md-center">
                                <p>
                                    @if(array_key_exists($employee->name, $totalMinutesPerEmployee))
                                        {{ '$' . $totalWagesPerEmployee[$employee->name] }}
                                    @endif
                                </p>
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
                            <div class="col-md-2 text-md-right">
                                <p><strong>Company</strong></p>
                            </div>
                            <div class="col-md-10">
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
                            </div>
                        </div>
                        @foreach($companies as $company)
                            <hr>
                            <div class="row">
                                <div class="col-md-2 text-md-right">
                                    <p><strong>{{ $company->name }}</strong></p>
                                </div>
                                <div class="col-md-10">
                                    @foreach($shifts as $shift)
                                        @if(($shift->user_id == $employee->id) && ($shift->company_id == $company->id))
                                            <div class="row">
                                                <div class="col-md">
                                                    <p>{{ $shift->clock_in_time_string }}</p>
                                                </div>
                                                <div class="col-md">
                                                    <p>{{ $shift->clock_out_time_string }}</p>
                                                </div>
                                                <div class="col-md">
                                                    <p>{{ floor(round($shift->duration_in_minutes / 60, 2)) }} hours, {{ $shift->duration_in_minutes % 60 }} minutes</p>
                                                </div>
                                                <div class="col-md">
                                                    <p>{{ $shift->note }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="row">
                <div class="col-md-2">
                    <p><strong>TOTALS:</strong></p>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md text-md-center">
                            <p><strong>{{ $totalShifts }}</strong></p>
                        </div>
                        <div class="col-md text-md-center">
                            <p><strong>{{ floor(round($totalMinutes / 60, 2)) }} hours, {{ $totalMinutes % 60 }} minutes</strong></p>
                        </div>
                        <div class="col-md text-md-center">
                            <p><strong>{{ '$' . $totalWages }}</strong></p>
                        </div>
                        <div class="col-md text-md-center">
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
@endsection
