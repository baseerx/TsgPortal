<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result Report Section</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="row">
            <div class="col-4">
                <img src="../img/ntdc_logo.png" class="float-right" alt="NTDC Logo" width="90" height="90">
            </div>
            <div class="col-6">
                <h4 class="pt-4">National Transmission & Despatch Company</h4>
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-center">
        @php
            $fid=Request::route('fid');
            $cTitle=\Illuminate\Support\Facades\DB::Table('add_courses')->where('cid',$fid)->where('status','1')->value('cdesc');
            echo '<h5>Report Of Lecture <span class="text-danger">'.$cTitle.'</span></h5>';
        @endphp
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Question</th>
                <th>Strongly Agree</th>
                <th>Agree</th>
                <th>Neutral</th>
                <th>Strongly Disagree</th>
                <th>Disagree</th>
            </tr>
            </thead>
            <tbody>
            @php
                $lecid=Request::route('lecid');
                $fid=Request::route('fid');
                $questions=\Illuminate\Support\Facades\DB::table('fquestions')->get();
                foreach ($questions as $key=>$questions)
                {
                     $stronglyAgree=\Illuminate\Support\Facades\DB::table('feedback')->where('question',$questions->fq_id)->where('option','Strongly Agree')->where('course',$fid)->count('option');
                     $Agree=\Illuminate\Support\Facades\DB::table('feedback')->where('question',$questions->fq_id)->where('option','Agree')->where('course',$fid)->count('option');
                     $Neutral=\Illuminate\Support\Facades\DB::table('feedback')->where('question',$questions->fq_id)->where('option','Neutral')->where('course',$fid)->count('option');
                     $stronglyDisagree=\Illuminate\Support\Facades\DB::table('feedback')->where('question',$questions->fq_id)->where('option','Strongly Disagree')->where('course',$fid)->count('option');
                     $disagree=\Illuminate\Support\Facades\DB::table('feedback')->where('question',$questions->fq_id)->where('option','Disagree')->where('course',$fid)->count('option');
                     echo '<tr>';
                     echo '<td  class="text-bold">'.++$key.'</td>';
                     echo '<td>'.$questions->question.'</td>';
                     echo '<td>'.$stronglyAgree.'</td>';
                     echo '<td>'.$Agree.'</td>';
                     echo '<td>'.$Neutral.'</td>';
                     echo '<td>'.$stronglyDisagree.'</td>';
                     echo '<td>'.$disagree.'</td>';
                }
            @endphp
            </tbody>
        </table>
    </div>
    <hr>
    <div class="d-flex justify-content-center">
        <button class="btn btn-danger" id="genReport">Generate Report</button>
    </div>
</div>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function(){ location.reload(); }, 50000);
    });
    $("#genReport").click(function(){
        window.print();
    });
</script>
