@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-success">
        <h1 class="display-3 text-center">Manage Shifts</h1>
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
                            <p class="mb-0">
                                <select id="employeeToPay" class="form-control" name="employeeToPay">
                                    <option value="n/a">n/a</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </p>
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
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-2">
                        <p class="mb-0"><strong>Company</strong></p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-0"><strong>Clock In</strong></p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-0"><strong>Clock Out</strong></p>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-0"><strong>Duration</strong></p>
                    </div>
                    <div class="col-md-1">
                        <p class="mb-0"><strong>Amount</strong></p>
                    </div>
                    <div class="col-md-1">
                        <p class="text-warning mb-0"><strong>Edit</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <p class="text-danger mb-0"><strong>Delete</strong></p>
            </div>
        </div>
        <hr>
        @foreach($shifts as $shift)
        <div class="row">
            <div class="col-md-11">
                <form class="editShift row" action="{{ route('pay/edit') }}" method="post">
                    @csrf
                    <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}">
                    <input type="hidden" name="shift_id" value="{{ $shift[0] }}">
                    <div class="col-md-2">
                        <p class="mb-0">
                            <select class="form-control" name="company_id">
                                @foreach($companies as $company)
                                    @if($company->id == $shift[1])
                                        <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                                    @else
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-0"><input class="form-control" type="datetime-local" name="clock_in_time" value="{{ $shift[2] }}"></p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-0"><input class="form-control" type="datetime-local" name="clock_out_time" value="{{ $shift[3] }}"></p>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-0">{{ floor(round($shift[4] / 60, 2)) }} hours, {{ $shift[4] % 60 }} minutes</p>
                    </div>
                    <div class="col-md-1">
                        <p class="mb-0">${{ $shift[5] }}</p>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-warning mb-0"><strong>Edit</strong></button>
                    </div>
                </form>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger mb-0" data-toggle="modal" data-target="#deleteModal{{ $shift[0] }}"><strong>Delete</strong></button>
            </div>
            <div class="modal fade" id="deleteModal{{ $shift[0] }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Delete Shift</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('pay/delete') }}" method="post">
                                @csrf
                                <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}">
                                <input type="hidden" name="shift_id" value="{{ $shift[0] }}">
                                <div class="form-group">
                                    <label for="reason_for_deletion">Why are you deleting this shift? (max: 140 characters)</label>
                                    <input type="text" name="reason_for_deletion" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete Shift</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @endforeach
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md"><p><strong>TOTALS:</strong></p></div>
            <div class="col-md"><p>{{ floor(round($totalWorked / 60, 2)) }} hours, {{ $totalWorked % 60 }} minutes</p></div>
            <div class="col-md"><p>${{ $totalPay }}</p></div>
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
                    <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}">
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
