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
    <div class="row">
        <div class="col-7 offset-3">
            @php
                $cid=Request::route('cid');
                $cid=explode('-',$cid);
                $cTitle=\Illuminate\Support\Facades\DB::Table('add_courses')->where('cid',$cid[0])->value('cdesc');
                echo '<h4 class="text-center">Result Report Of Training <br><span class="text-danger">'.$cTitle.'</span></h5>';
            @endphp
        </div>
        <div class="col-2">
            <small class="text-danger d-flex justify-content-right">Date:{{date('d-m-Y')}}</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th>Sr #</th>
                <th>Roll#</th>
                <th>Name</th>
                <th>Total</th>
                <th>Correct</th>
                <th>Wrong</th>
                <th>Attempted</th>
                <th>UnAttempted</th>
                <th>Marks</th>
                <th>Percentage</th>
            </tr>
            </thead>
            <tbody>
            @php
                $cid=Request::route('cid');
                $cid=explode('-',$cid);
                $marksCompare=0;
                 $users=\Illuminate\Support\Facades\DB::table('result_reports')->where('course',$cid[0])->where('exam_id',$cid[1])->select('userid')->groupBy('userid')->get();
                  foreach ($users as $key=>$users)
                      {
                          $hrisId=$users->userid;
                          $correct=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$hrisId)->where('exam_id',$cid[1])->where('course',$cid[0])->where('flag','1')->count('flag');
                           $wrongMcqs=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$hrisId)->where('exam_id',$cid[1])->where('course',$cid[0])->where('flag','0')->count('flag');
                           $percentage=\Illuminate\Support\Facades\DB::table('submit_results')->where('rollno',$hrisId)->where('exam_id',$cid[1])->where('course',$cid[0])->value('percentage');
                           $marksPerMcqs=\Illuminate\Support\Facades\DB::table('examinations')->where('exam_id',$cid[1])->where('course',$cid)->value('marks');
                           $totalMcqs=\Illuminate\Support\Facades\DB::table('write_papers')->where('exam_id',$cid[1])->where('course',$cid)->count('question');
                           $checkUserType=\Illuminate\Support\Facades\DB::table('submit_results')->where('exam_id',$cid[1])->where('course',$cid[0])->where('rollno',$hrisId)->exists();
                           $marksObtained=$marksPerMcqs*$correct;

                           $totalMarks=$totalMcqs*$marksPerMcqs;
                           $attempted=\Illuminate\Support\Facades\DB::table('result_reports')->where('exam_id',$cid[1])->where('userid',$hrisId)->where('course',$cid[0])->count('flag');
                             $unattempted=$totalMcqs-$attempted;
                             echo '<tr class="text-center">';
                             echo '<td  class="text-bold">'.++$key.'</td>';
                             echo '<td>'.$hrisId.'</td>';

                               $extEmail=DB::table('trainees')
                                ->join('create_letter', 'create_letter.letterid', '=', 'trainees.letterid')
                                ->join('add_courses', 'add_courses.cid', '=', 'create_letter.course')
                                ->where('add_courses.status', '=', '1')
                                ->where('trainees.tid', '=', $hrisId)
                                ->value('trainees.email');

                             if (!empty($extEmail))
                               {
                                  $externalUserName=\Illuminate\Support\Facades\DB::table('submit_results')->where('course',$cid[0])->where('exam_id',$cid[1])->where('rollno',$hrisId)->value('name');
                                   echo '<td>'.$externalUserName.'</td>';
                               }
                              else
                               {
                                    $userName = DB::connection('mysql2')->table('personal')
                                   ->where('personal.MyId', '=', $hrisId)->select('personal.Name as name')->get();
                                   
                                    echo '<td>'.$userName[0]->name.'</td>';
                               }
                             echo '<td>'.$totalMarks.'</td>';
                             echo '<td>'.$correct.'</td>';
                             echo '<td>'.$wrongMcqs.'</td>';
                             echo '<td>'.$attempted.'</td>';
                             echo '<td>'.$unattempted.'</td>';
                             echo '<td>'.$marksObtained.'</td>';
                             echo '<td>'.round($percentage,2).'</td>';
                             echo '</tr>';

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
        setInterval(function () {
            location.reload();
        }, 50000);
    });
    $("#genReport").click(function () {
        window.print();
    });
</script>
