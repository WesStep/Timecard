@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-warning">
        <h1 class="display-3 text-center">Edit Your Account Info</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default margin-bottom">
                    <div class="card-body">
                        @if(Session::has('info'))
                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-warning">{{ Session::get('info') }}</p>
                            </div>
                        </div>
                        @endif
                        @include('partials.errors')
                        <form action="{{ route('dashboard/edit') }}" method="post">
                            <div class="form-group row">
                                <label for="employeeName" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="name" placeholder="John Doe" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="employeeEmail" class="col-sm-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="email" placeholder="john.doe@example.com"value="{{ $user->email }}">
                                </div>
                            </div>
                            @csrf
                            <div class="form-group row no-margin">
                                <div class="col-md-8 offset-sm-4">
                                    <button type="submit" name="updateAccount" class="btn btn-warning no-margin">Update Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
