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
                $cTitle=\Illuminate\Support\Facades\DB::Table('add_courses')->where('cid',$cid)->value('cdesc');
                echo '<h5 class="text-center py-0">Result Report Of Training <br><span class="text-danger">'.$cTitle.'</span></h5>';
            @endphp
        </div>
        <div class="col-2">
            <small class="text-danger d-flex justify-content-right">Date:{{date('d-m-Y')}}</small>
        </div>
    </div>
    <h5 class="text-center text-primary">List In Descending Order</h5>
    <div class="d-flex justify-content-center">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Roll#</th>
                <th>Name</th>
                <th>Percentage</th>
            </tr>
            </thead>
            <tbody>
            @php
                $cid=Request::route('cid');
                  $position=\Illuminate\Support\Facades\DB::table('submit_results')->where('course',$cid)->orderBy('percentage','desc')->get();
                     foreach ($position as $key=>$position)
                      {
                           echo '<tr>';
                             echo '<td>'.++$key.'</td>';
                             echo '<td>'.$position->rollno.'</td>';
                             echo '<td>'.$position->name.'</td>';
                             echo '<td>'.round($position->percentage, 2).'</td>';
                             echo '</tr>';
                      }
            @endphp
            </tbody>
        </table>
    </div>
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
