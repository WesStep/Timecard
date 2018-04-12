@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Business Statistics</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 bg-info">
                <h3 class="text-center mt-4">Details:</h3>
                <hr>
                <div class="form-group row">
                    <div class="col-md-12 checkbox">
                        <label class="checkbox-container no-margin">
                            <input id="paid" type="checkbox" name="paid"> Notes?
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 checkbox">
                        <label class="checkbox-container no-margin">
                            <input id="paid" type="checkbox" name="paid"> Clock In/Out Times?
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 checkbox">
                        <label class="checkbox-container no-margin">
                            <input id="paid" type="checkbox" name="paid"> Duration?
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 checkbox">
                        <label class="checkbox-container no-margin">
                            <input id="paid" type="checkbox" name="paid"> Paid?
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn mr-0 mb-4 btn-dark">Print</button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <h1 class="text-center">Week of the {{ $weekAgo->format('jS') }} through the {{ $today->format('jS') }}</h1>
                <div class="row">
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
                @foreach($users as $user)
                    <div class="row">
                        <div class="col-md-2 text-md-right">
                            <p><strong>{{ $user->name }} ID: {{ $user->id }}</strong></p>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <p>Hours worked: 20</p>
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">Notes</button>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-item">
                                            <hr>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, adipisci amet blanditiis dolores ea eveniet illo ipsa itaque magni maiores non</p>
                                        </div>
                                        <div class="dropdown-item">
                                            <hr>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, adipisci amet blanditiis dolores ea eveniet illo ipsa itaque magni maiores non</p>
                                        </div>
                                        <div class="dropdown-item">
                                            <hr>
                                            <p>example note</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <hr>
            @endforeach
            </div>
        </div>
    </div>
@endsection
