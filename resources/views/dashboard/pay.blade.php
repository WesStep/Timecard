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
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-info">{{ Session::get('info') }}</p>
                </div>
            </div>
            @endif
            @include('partials.errors')
            <form action="{{ route('dashboard/pay/show') }}" method="get">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="employeeToPay" class="col-sm-4 col-form-label text-md-right">Employee:</label>
                    <div class="col-md-6">
                        <select id="employeeToPay" class="form-control" name="employeeToPay">
                            <option value="n/a">n/a</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="">
                            <button type="submit" name="lookupEmployee" class="btn btn-lg btn-primary no-margin">Employee Lookup</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @isset($shifts)
            <div class="row">
                <div class="col-md">
                    <p><strong>Company</strong></p>
                </div>
                <div class="col-md">
                    <p><strong>Clock In</strong></p>
                </div>
                <div class="col-md">
                    <p><strong>Clock Out</strong></p>
                </div>
                <div class="col-md">
                    <p><strong>Duration</strong></p>
                </div>
                <div class="col-md">
                    <p><strong>Amount to Pay</strong></p>
                </div>
                <div class="col-md-1">
                    <p class="text-danger"><strong>Delete</strong></p>
                </div>
            </div>
            <hr>
            @foreach($shifts as $shift)
            <div class="row">
                <div class="col-md">
                    <p>{{ $shift[0] }}</p>
                </div>
                <div class="col-md">
                    <p>{{ $shift[1]->format('h:i A') }}</p>
                </div>
                <div class="col-md">
                    <p>{{ $shift[2]->format('h:i A') }}</p>
                </div>
                <div class="col-md">
                    <p>{{ floor(round($shift[3] / 60, 2)) }} hours, {{ $shift[3] % 60 }} minutes</p>
                </div>
                <div class="col-md">
                    <p>${{ $shift[4] }}</p>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger"><strong>X</strong></button>
                </div>
            </div>
            <hr>
            @endforeach
            <div class="row">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"><p><strong>TOTALS:</strong></p></div>
                <div class="col">{{ floor(round($totalWorked / 60, 2)) }} hours, {{ $totalWorked % 60 }} minutes</div>
                <div class="col">${{ $totalPay }}</div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <form action="#" method="post">
                    <div class="form-group">
                        <div class="col-md-6 offset-md-4">
                            <div class="checkbox">
                                <label class="checkbox-container no-margin">
                                    <input type="checkbox" name="paid"> Paid?
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" name="pay" class="btn btn-lg btn-primary no-margin">Record Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        @endisset
        </div>
    </div>
@endsection
