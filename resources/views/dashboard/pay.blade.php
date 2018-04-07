@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-success">
        <h1 class="display-3 text-center">Manage Payments</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @if(Session::has('info'))
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
            @endif
            @include('partials.errors')
            <div class="col-md-12">
                <form action="{{ route('dashboard/pay/show') }}" method="get">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="employeeToPay" class="col-md-2 col-form-label text-md-right">Employee:</label>
                        <div class="col-md-4">
                            <select id="employeeToPay" class="form-control" name="employeeToPay">
                                <option value="n/a">n/a</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="lookupEmployee" class="btn btn-lg btn-primary no-margin">Employee Lookup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @isset($shifts)
        <hr>
        <div class="row">
            <div class="col-md">
                <p class="mb-0"><strong>Company</strong></p>
            </div>
            <div class="col-md">
                <p class="mb-0"><strong>Clock In</strong></p>
            </div>
            <div class="col-md">
                <p class="mb-0"><strong>Clock Out</strong></p>
            </div>
            <div class="col-md">
                <p class="mb-0"><strong>Duration</strong></p>
            </div>
            <div class="col-md">
                <p class="mb-0"><strong>Amount to Pay</strong></p>
            </div>
            <div class="col-md-1">
                <p class="text-danger mb-0"><strong>Delete</strong></p>
            </div>
        </div>
        <hr>
        @foreach($shifts as $shift)
        <div class="row">
            <div class="col-md">
                <p class="mb-0">{{ $shift[0] }}</p>
            </div>
            <div class="col-md">
                <p class="mb-0">{{ $shift[1]->format('h:i A') . " on " . $shift[1]->format('l') . " the " . $shift[1]->format('jS') }}</p>
            </div>
            <div class="col-md">
                <p class="mb-0">{{ $shift[2]->format('h:i A') . " on " . $shift[2]->format('l') . " the " . $shift[2]->format('jS') }}</p>
            </div>
            <div class="col-md">
                <p class="mb-0">{{ floor(round($shift[3] / 60, 2)) }} hours, {{ $shift[3] % 60 }} minutes</p>
            </div>
            <div class="col-md">
                <p class="mb-0">${{ $shift[4] }}</p>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger mb-0"><strong>X</strong></button>
            </div>
        </div>
        <hr>
        @endforeach
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md"><p><strong>TOTALS:</strong></p></div>
            <div class="col-md">{{ floor(round($totalWorked / 60, 2)) }} hours, {{ $totalWorked % 60 }} minutes</div>
            <div class="col-md">${{ $totalPay }}</div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md">
                <form action="{{ route('dashboard/pay') }}" method="post">
                    <div class="form-group row">
                        <div class="col-md-8 offset-col-4 checkbox">
                            <label class="checkbox-container no-margin">
                                <input id="paid" type="checkbox" name="paid" required> Paid?
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="hidden" id="employee_id" name="employee_id" value="{{ $id }}">
                    <div class="form-group row">
                        <div class="col-md">
                            <button type="submit" name="pay" class="btn btn-lg btn-primary no-margin">Record</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
        @endisset
    </div>
@endsection
