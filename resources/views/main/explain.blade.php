@extends('layouts/master')

@section('jumbotron')
	<div class="jumbotron">
		<h1 class="display-3 text-center">How does Timecard work?</h1>
	</div>
@endsection



@section('content')
	<div class="container margin-bottom">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card card-default mb-4">
					<div class="card-body">
						@if(Session::has('info'))
							<p class="alert alert-success">{{ Session::get('info') }}</p>
						@endif
						<h3>General Idea</h3>
						<p>Timecard.wesstep.com is a project I made in college. The original version of this app was made for a client who uses this software for his companys' employees. There are three main dashboards to login to: one for <strong>employees</strong>, one for <strong>payroll admins</strong>, and one for the <strong>business owner(s)</strong>.</p>
						<p>You can access each of these respective accounts by using the following credentials:</p>
						<div class="list-group">
							<div class="list-group-item list-group-item-action flex-column align-items-start">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1">Employee Account:</h5>
								</div>
								<p class="mb-1">Username: sample.employee@gmail.com</p>
								<p class="mb-1">Password: NewPass1234!</p>
							</div>
							<div class="list-group-item list-group-item-action flex-column align-items-start">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1">Payroll Admin Account:</h5>
								</div>
								<p class="mb-1">Username: sample.payroll.admin@gmail.com</p>
								<p class="mb-1">Password: NewPass1234!</p>
							</div>
							<div class="list-group-item list-group-item-action flex-column align-items-start">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1">Business Owner Account:</h5>
								</div>
								<p class="mb-1">Username: sample.business.owner@gmail.com</p>
								<p class="mb-1">Password: NewPass1234!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card card-default mb-4">
					<div class="card-body">
						<h3>Employee Account</h3>
						<p>Employees have the ability to login to their accounts, change their personal information, clock in/out, and view previous shifts worked.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card card-default mb-4">
					<div class="card-body">
						<h3>Payroll Admin Account</h3>
						<p>Payroll admins have the ability to login to their accounts, change their personal information, view employees' shifts, mark employee time as paid, and make edits to employee shifts as needed.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card card-default mb-4">
					<div class="card-body">
						<h3>Business Owner Account</h3>
						<p>Business Owners have the ability to login to their accounts, change their personal information, view employees' shifts by date and organized by company. The Business Owner dashboard allows them to be create, update, or delete multiple companies.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card card-default mb-4">
					<div class="card-body">
						<h3>Make sure it will work</h3>
						<p>As this is a public-facing site and credentials are on this page, anyone can access this app and create fictional shifts, companies, and other data. It is important that, before you go ahead and test out the app, you reset any data stored in the database first.</p>
						<p>Reset the database <a href="{{ route('reset') }}">Here</a>.</p>
						@if(Session::has('info'))
							<p class="alert alert-success">{{ Session::get('info') }}</p>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<a class="lead" href="{{ route('login') }}">Back to Login</a>
			</div>
		</div>
	</div>
@endsection