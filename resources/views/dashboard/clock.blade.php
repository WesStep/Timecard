@extends('layouts.master')

@section('jumbotron')
    @if($is_clocked_in == true)
        <div class="jumbotron">
            <h1 class="display-3 text-center">Clock Out</h1>
        </div>
    @elseif($is_clocked_in == false)
        <div class="jumbotron">
            <h1 class="display-3 text-center">Clock In</h1>
        </div>
    @endif

@endsection

@section('content')
    <div class="container">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-8">
                <div class="card card-default margin-bottom">
                    <div class="card-body">
                        @if(Session::has('info'))
                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-info">{{ Session::get('info') }}</p>
                            </div>
                        </div>
                        @endif
                        @include('partials.errors')
                        @if($is_clocked_in == false)
                        <form action="{{ route('dashboard/clockIn') }}" method="post">
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="company" class="form-label">Clock in For</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" name="company" id="company">
                                        @foreach($companies as $company)
                                            <option value="{{ $company->name }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="clock_in_time">Clock In Time:</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="datetime-local" name="clock_in_time" value="{{ $currentTime }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                @csrf
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="clock-in" class="btn btn-lg btn-success">Clock In</button>
                                </div>
                            </div>
                        </form>
                        @elseif($is_clocked_in == true)
                        <form action="{{ route('dashboard/clockOut') }}" method="post">
                            <div class="form-group row">
                                <label for="note" class="col-md-4 col-form-label text-md-right">Note</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="note" placeholder="What was accomplished?">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="clock_out_time">Clock Out Time:</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="datetime-local" name="clock_out_time" value="{{ $currentTime }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                @csrf
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="clock-out" class="btn btn-lg btn-danger">Clock Out</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>If an error has occured, notify the payroll admin immediately.</p>
            </div>
        </div>
    </div>
@endsection
