<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lecture Report Generate</title>
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
            $lecid=Request::route('lecid');
          $lecTitle=\Illuminate\Support\Facades\DB::Table('presentations')->where('pid',$lecid)->value('description');
         echo '<h5>Report Of Lecture <span class="text-danger">'.$lecTitle.'</span></h5>';
        @endphp
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Question</th>
                <th>Excellent</th>
                <th>Good</th>
                <th>Average</th>

            </tr>
            </thead>
            <tbody>

            @php
                $questions=\Illuminate\Support\Facades\DB::table('lec_questions')->orderBy('qid')->get();
                  $lecid=Request::route('lecid');
                foreach ($questions as $key=>$questions)
                {
                     $excellent=\Illuminate\Support\Facades\DB::select("SELECT COUNT(answer) as count FROM lecture_feeds WHERE lecture='$lecid' AND question='$questions->question' AND answer='Excellent'");
                     $good=\Illuminate\Support\Facades\DB::select("SELECT COUNT(answer) as count FROM lecture_feeds WHERE lecture='$lecid' AND question='$questions->question' AND answer='Good'");
                     $average=\Illuminate\Support\Facades\DB::select("SELECT COUNT(answer) as count FROM lecture_feeds WHERE lecture='$lecid' AND question='$questions->question' AND answer='Average'");

                     echo '<tr>';
                     echo '<td>'.++$key.'</td>';
                     echo '<td class="text-bold">'.$questions->question.'</td>';
                     echo '<td>'.$excellent[0]->count.'</td>';
                     echo '<td>'.$good[0]->count.'</td>';
                     echo '<td>'.$average[0]->count.'</td>';
                     echo'</tr>';
                }
            @endphp

            </tbody>
        </table>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Recommended for Future Course?</th>
                <th>Yes</th>
                <th>No</th>

            </tr>
            </thead>
            <tbody>
            @php
                $lecid=Request::route('lecid');
                $yes=\Illuminate\Support\Facades\DB::table('lecture_feeds')->where('lecture',$lecid)->where('question','Recommended for Future Course?')->where('answer','yes')->count();
                $no=\Illuminate\Support\Facades\DB::table('lecture_feeds')->where('lecture',$lecid)->where('question','Recommended for Future Course?')->where('answer','no')->count();


            @endphp
            <tr><td class="text-bold">1</td><td>Recommended for Future Course?</td><td>{{$yes}}</td><td>{{$no}}</td></tr>
            </tbody>
        </table>
    </div>

    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Are there any thoughts you'd like to share? (Comments)*</th>

            </tr>
            </thead>
            <tbody>
            @php
                $lecid=Request::route('lecid');
                $questions=\Illuminate\Support\Facades\DB::table('feed_subs')->where('lectureid',$lecid)->get();
                foreach ($questions as $key=>$questions)
                {
                     echo '<tr>';
                     echo '<td  class="text-bold">'.++$key.'</td>';
                     echo '<td>'.$questions->questionone.'</td>';
                     echo '</tr>';
                }
            @endphp
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <button class="btn btn-danger" id="genReport">Generate Report</button>
    </div>
</div>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>
<script type="text/javascript">
    $("#genReport").click(function(){
        window.print();
    });
</script>
