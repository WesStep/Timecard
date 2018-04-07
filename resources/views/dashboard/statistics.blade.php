@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Business Statistics</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <hr></hr>
        @foreach($users as $user)
        <div class="row">
            <div class="col-lg-5 text-lg-right">
                <h3 class="mb-0">{{ $user->name }} ID: {{ $user->id }}</h3>
            </div>
            <div class="col-lg-7 text-lg-left">
                <p class="mb-0 mt-1"><strong>Hours worked last week:</strong> ### | <strong>Notes from past week's shifts:</strong> "..."</p>
            </div>
        </div>
        <hr></hr>
        @endforeach
    </div>
@endsection
