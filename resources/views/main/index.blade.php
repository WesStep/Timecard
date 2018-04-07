@extends('layouts.master')

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class=" display-3 text-center">Timecard</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ route('login') }}" class="btn btn-lg btn-primary">Login</a>
            </div>
        </div>
    </div>
@endsection
