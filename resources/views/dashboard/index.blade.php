@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron">
        <h1 class="display-3 text-center">{{ $userFirstName }}'s Dashboard</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        @if($role[0] == 'employee')
        <div class="row">
            <div class="col-md-12">
                <h3>Employee Quick Links</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-lg btn-warning" href="{{ route('dashboard/edit') }}">Edit Info</a>
                <a class="btn btn-lg btn-success" href="{{ route('dashboard/clock') }}">Clock In/Out</a>
                <a class="btn btn-lg btn-info" href="{{ route('dashboard/history') }}">Work History</a>
            </div>
        </div>
        @elseif($role[0] == 'payroll admin')
        <div class="row">
            <div class="col-md-12">
                <h3>Payroll Admin Quick Links</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-lg btn-warning" href="{{ route('dashboard/edit') }}">Edit Info</a>
                <!-- <a class="btn btn-lg btn-warning" href="{{ route('dashboard/manage') }}">Manage Accounts</a> -->
                <a class="btn btn-lg btn-success" href="{{ route('dashboard/pay') }}">Manage Shifts</a>
            </div>
        </div>
        @elseif($role[0] == 'business owner')
        <div class="row">
            <div class="col-md-12">
                <h3>Business Owner Quick Links</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-lg btn-warning" href="{{ route('dashboard/edit') }}">Edit Info</a>
                <!-- <a class="btn btn-lg btn-warning" href="{{ route('dashboard/manage') }}">Manage Accounts</a> -->
                <a class="btn btn-lg btn-warning" href="{{ route('dashboard/company') }}">Manage Companies</a>
                <a class="btn btn-lg btn-info" href="{{ route('dashboard/statistics') }}">Business Stats</a>
            </div>
        </div>
        @endif
    </div>
@endsection
