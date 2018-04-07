@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-danger">
        <h1 class="display-3 text-center">Delete Accounts</h1>
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
                                <p class="alert alert-danger">{{ Session::get('info') }}</p>
                            </div>
                        </div>
                        @endif
                        <form action="{{ route('dashboard/delete') }}" method="post">
                            <div class="form-group row">
                                <label for="accountToDelete" class="col-sm-4 col-form-label text-md-right">Account To Delete</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="accountToDelete">
                                        <option value="n/a">n/a</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group row justify-content-center no-margin">
                                <button type="submit" name="deleteAccount" class="btn btn-sm btn-danger no-margin">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
