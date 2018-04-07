@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-warning">
        <h1 class="display-3 text-center">Manage Companies</h1>
    </div>
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
                        <h1 class="text-center">Add Companies</h1>
                        <form action="{{ route('dashboard/company/add') }}" method="post">
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="newCompany">New Company</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="newCompany" type="text" class="form-control" name="newCompany">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    @csrf
                                    <button type="submit" name="addCompany" class="btn btn-lg btn-success">Add Company</button>
                                </div>
                            </div>
                        </form>
                        <hr>

                        <h1 class="text-center">Edit Companies</h1>
                        <form action="{{ route('dashboard/company/edit') }}" method="post">
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="companyToEdit" class="form-label">Company to Edit</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" name="companyToEdit" id="companyToEdit">
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="companyName" class="form-label">New Company Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="companyName" name="companyName" type="text" class="form-control">
                                </div>
                            </div>
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="editCompany" class="btn btn-lg btn-warning">Edit Company</button>
                                </div>
                            </div>
                        </form>
                        <hr>

                        <h1 class="text-center">Delete Companies</h1>
                        <form action="{{ route('dashboard/company/delete') }}" method="post">
                            <div class="form-group row">
                                <div class="col-md-4 text-md-right">
                                    <label for="companyToDelete" class="form-label">Company to Delete</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" name="companyToDelete" id="companyToDelete">
                                        @foreach($companies as $company)
                                            <option value="{{ $company->name }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="deleteCompany" class="btn btn-lg btn-danger">Delete Company</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection