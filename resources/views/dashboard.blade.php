@extends('layouts.app')
@section('content')

    @if(Auth::user()->type == "student")

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-accent-primary">
                        <div class="card-header"> Dashboard
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    @if($data["status"] == 1)
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div class="btn-group float-right">
                                                </div>
                                                <div class="text-value-lg">Examination Details</div>
                                                <div>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto dolore doloremque nulla.
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                                <a href="https://salesforce.altustechit.com/api-entrance-exam?key=123321456&registrationID=111111&exam_type=entrance-exam" id="takeExam" class="btn btn-block btn-secondary p-3">Take exam</a>
                                                {{--<a href="{{route('takeexam')}}" id="takeExam" class="btn btn-block btn-secondary p-3">Take exam</a>--}}
                                            </div>
                                        </div>
                                    @else
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div class="btn-group float-right">
                                                </div>
                                                <div class="text-value-lg">Announcement</div>
                                                <div>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto dolore doloremque nulla.
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- /.col-->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-info">
                                        <div class="card-body pb-0">
                                            <div class="text-value-lg">{{$data["students"]}}</div>
                                            <div>Students</div>
                                        </div>
                                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-warning">
                                        <div class="card-body pb-0">
                                            <div class="btn-group float-right">
                                            </div>
                                            <div class="text-value-lg">{{$data["subject"]}}</div>
                                            <div>Subjects</div>
                                        </div>
                                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                                            <canvas class="chart" id="card-chart3" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                            <div class="row justify-content-center d-none">
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">New Students</div>
                                    <strong>{{$data["new"]}}</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$data['new']}}%"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Transferees</div>
                                    <strong>{{$data["transferees"]}}</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{$data['transferees']}}%" aria-valuenow="20" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Old Students</div>
                                    <strong>{{$data["old"]}}</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$data['old']}}%"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-accent-primary">
                        <div class="card-header"> Dashboard
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0">
                                            <div class="btn-group float-right">
                                            </div>
                                            <div class="text-value-lg">{{$data["faculty"]}}</div>
                                            <div>Faculty</div>
                                        </div>
                                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                            <canvas class="chart" id="card-chart1" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-info">
                                        <div class="card-body pb-0">
                                            <div class="text-value-lg">{{$data["students"]}}</div>
                                            <div>Students</div>
                                        </div>
                                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-warning">
                                        <div class="card-body pb-0">
                                            <div class="btn-group float-right">
                                            </div>
                                            <div class="text-value-lg">{{$data["subject"]}}</div>
                                            <div>Subjects</div>
                                        </div>
                                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                                            <canvas class="chart" id="card-chart3" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->

                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="card-title mb-0">Enrollees</h4>
                                            <div class="small text-muted">S.Y 2020-2021</div>
                                        </div>
                                    </div>
                                    <!-- /.row-->
                                </div>
                                <div class="card-footer">
                                    <div class="row text-center">
                                        <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                            <div class="text-muted">New Students</div>
                                            <strong>{{$data["new"]}}</strong>
                                            <div class="progress progress-xs mt-2">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$data['new']}}%"
                                                     aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                            <div class="text-muted">Transferees</div>
                                            <strong>{{$data["transferees"]}}</strong>
                                            <div class="progress progress-xs mt-2">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                     style="width: {{$data['transferees']}}%" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                            <div class="text-muted">Old Students</div>
                                            <strong>{{$data["old"]}}</strong>
                                            <div class="progress progress-xs mt-2">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$data['old']}}%"
                                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection


@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            @if($data["status"] == 1)

            $("#takeExam123").click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    crossDomain: true,
                    url: "https://salesforce.altustechit.com/api-entrance-exam",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    // url: "http://127.0.0.1:8000/takeexam/",
                    data: {
                        key: '123321456',
                        registrationID: '111111',
                        exam_type: 'entrance-exam'
                    },
                    success: function(result) {
                        console.log(result);
                        alert('ok');
                    },
                    error: function (jqXHR, exception) {
                        // console.log(result);
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }

                        console.log(msg);
                        console.log(jqXHR);
                        console.log(exception);
                        // console.log(request.status);
                        // console.log(request.responseText);
                        // alert(request.responseText);
                    }
                });
            });


            @endif
        });
    </script>
@endsection
