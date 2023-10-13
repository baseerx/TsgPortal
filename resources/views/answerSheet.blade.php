<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Result Report Section</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        @media print {
            .pagebreak {
                clear: both;
                page-break-after: always;
            }
        }
    </style>
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
                 $vals=explode('-',$cid);
                 $cid=$vals[1];
                 $tid=$vals[0];
                $cTitle=\Illuminate\Support\Facades\DB::Table('add_courses')->where('cid',$cid)->value('cdesc');
                echo '<h5 class="text-center">Detail Result Report Of Training <br><span class="text-danger">'.$cTitle.'</span></h5>';
            @endphp
        </div>
        <div class="col-2">
            <small class="text-danger d-flex justify-content-right">Date:{{date('d-m-Y')}}</small>
        </div>
    </div>

    <div class="table-responsive">
        @php
            $cid=Request::route('cid');
            $vals=explode('-',$cid);
            $cid=$vals[1];
            $tid=$vals[0];

                           $traineeDetail=\Illuminate\Support\Facades\DB::table('trainees')->where('tid',$tid)->first();
                           $traineeData=\Illuminate\Support\Facades\DB::table('submit_results')->where('email',$traineeDetail->email)->where('course',$cid)->first();
                           echo "<div class='d-flex flex-row'>";
                           echo '<h4 class="p-2">Roll No: '.$traineeData->rollno.'</h4>';
                           echo '<h4 class="p-2 text-danger">Name: '.$traineeDetail->name.'</h4>';
                           echo "</div>";
                           echo "<table class='table table-bordered'>
                           <thead>
                           <tr class='text-center'>
                               <th>Sr #</th>
                               <th>Question</th>
                               <th>Correct Option</th>
                               <th>Selected Option</th>
                               <th>Flag</th>
                           </tr>
                           </thead>
                           <tbody>";
                                    $totalMcqs=\Illuminate\Support\Facades\DB::table('write_papers')->where('course',$cid)->get();
                                    foreach ($totalMcqs as $key=>$totalMcqs)
                                     {
                                         $selected=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$traineeData->rollno)->where('course',$cid)->where('paperid',$totalMcqs->paperid)->value('selected');
                                         $flag=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$traineeData->rollno)->where('course',$cid)->where('paperid',$totalMcqs->paperid)->value('flag');
                                         echo '<tr><td>'.++$key.'</td><td><b class="text-info">Question:  </b>'.$totalMcqs->question.'</br><div class="d-flex flex-row"><div class="pl-5">A:'.$totalMcqs->first.'</div><div class="pl-5">B:'.$totalMcqs->second.'</div><div class="pl-5">C:'.$totalMcqs->third.'</div><div class="pl-5">D:'.$totalMcqs->fourth.'</div><div class="pl-5">';
                                           if (!empty($totalMcqs->fifth))
                                               {
                                                echo 'E:'.$totalMcqs->fifth;
                                               }
                                           else
                                               {
                                                   echo '';
                                               }

                                         echo '</div><div></div></td><td>'.$totalMcqs->answer.'</td><td>'.$selected.'</td>';
                                         if (!strcmp($flag,'1'))
                                         echo '<td class="text-info">Correct</td>';
                                         else
                                         echo '<td class="text-danger">InCorrect</td>';
                                         echo '</tr>';
                                     }
                                     echo "</tbody></table>";

                                     echo "</br>";
                  $totalAttempted=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$traineeData->rollno)->where('course',$cid)->count();
                  $Percentage=\Illuminate\Support\Facades\DB::table('submit_results')->where('rollno',$traineeData->rollno)->where('course',$cid)->value('percentage');
                  $Result=\Illuminate\Support\Facades\DB::table('submit_results')->where('rollno',$traineeData->rollno)->where('course',$cid)->value('result');
                  $Correct=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$traineeData->rollno)->where('course',$cid)->where('flag','1')->count();
                  $Incorrect=\Illuminate\Support\Facades\DB::table('result_reports')->where('userid',$traineeData->rollno)->where('course',$cid)->where('flag','0')->count();
                  echo '<h4 class="text-danger">Summary</h4>';
                   echo "<table class='table table-bordered'>
                           <thead>
                           <tr class='text-center'>

                               <th>Total Attempted</th>
                               <th>Percentage</th>
                               <th>Result</th>
                               <th>Correct</th>
                               <th>Incorrect</th>
                           </tr>
                           </thead>
                           <tbody>";
                                     echo '<tr class="text-center"><td>'.$totalAttempted.'</td><td>'.round($Percentage,2).'</td><td>'.$Result.'</td><td>'.$Correct.'</td><td>'.$Incorrect.'</td></tr><br>';
                    echo "</tbody></table>";

        @endphp


    </div>


</div>
<div class="d-flex justify-content-center">
    <button class="btn btn-danger" id="genReport">Generate Report</button>
</div>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>
<script type="text/javascript">
    $("#genReport").click(function () {
        window.print();
    });
</script>
