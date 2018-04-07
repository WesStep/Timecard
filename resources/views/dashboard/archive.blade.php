@extends('layouts.master')

@section('jumbotron')
    <div class="jumbotron bg-info">
        <h1 class="display-3 text-center">Work History Archives</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Work done in {{ $month }}, {{ $year }}</h1>
                <hr style="border-top: 1px solid #17a2b8">
                @foreach($monthDays as $day)
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>{{ $day[0]->format('l (jS)') }} Shifts: </strong></p>
                        </div>
                        <div class="col-md-9">
                            @foreach($day[3] as $shift)
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Clock In Time:</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{ $shift[1]->format('l jS h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Clock Out Time:</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{ $shift[2]->format('l jS h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Duration:</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{ floor(round($shift[3] / 60, 2)) }} hours, {{ $shift[3] % 60 }} minutes</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Note:</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{ $shift[4] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Company:</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{ $shift[5] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Estimated Pay:</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        <p>${{ $shift[6] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-md-right">
                                        <p><strong>Paid?</strong></p>
                                    </div>
                                    <div class="col-md-9">
                                        @if($shift[7] == true)
                                            <p class="text-success"><strong>YES</strong></p>
                                        @elseif($shift[7] == false)
                                            <p class="text-danger"><strong>NO</strong></p>
                                        @endif
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                    <hr style="border-top: 1px solid #17a2b8">
                @endforeach
            </div>
            @include('partials/sidebar')
        </div>
    </div>
@endsection