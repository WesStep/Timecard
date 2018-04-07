@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-warning">
        <h1 class="display-3 text-center">Manage Employee Accounts</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default margin-bottom">
                    <div class="card-body">
                        <div class="row">
                            <p class="text-md-right col-sm-4 col-form-label text-md-right">Tasks</p>
                            <div class="col-md-8">
                                <a class="btn btn-lg btn-success" href="{{ route('register') }}">Create Accounts</a>
                                <a class="btn btn-lg btn-danger" href="{{ route('dashboard/delete') }}">Delete Accounts</a>
                            </div>
                        </div>
                        <form action="{{ route('dashboard/manage') }}" method="post">
                            <div class="form-group row">
                                <label for="employee" class="col-sm-4 col-form-label text-md-right">Account to View</label>
                                <div class="col-md-8">
                                    <select id="employee" class="form-control" name="employee">
                                        <option value="n/a">n/a</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="employeeName" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input id="editName" class="form-control" type="text" name="employeeName" placeholder="John Doe">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="employeePayRate" class="col-sm-4 col-form-label text-md-right">Pay Rate</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input id="editPayRate" type="number" class="form-control" placeholder="10.00" min="0" max="100">
                                        <div class="input-group-append">
                                            <span class="input-group-text">per hour</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="employeeEmailAddress" class="col-sm-4 col-form-label text-md-right">Email Address</label>
                                <div class="col-md-8">
                                    <input id="editEmailAddress" class="form-control" type="text" name="employeeEmailAddress" placeholder="john.doe@example.com">
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group row no-margin">
                                <div class="col-md-8 offset-sm-4">
                                    <button type="submit" name="update" class="btn btn-lg btn-warning no-margin">Update John Doe's Info</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#employee').change(function() {
                var employee_id = $(this).val();
                console.log(employee_id);
            });
        });
    </script>
@endsection
