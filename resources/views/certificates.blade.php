<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon"/>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>NATIONAL TRANSMISSION & DESPATCH COMPANY LIMITED (NTDC) PAKISTAN</title>

    <!-- Fonts -->
    <link href="../fonts/fonts.css" rel="stylesheet">
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css" media="print">
        @page
        {
            size:  auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }

        html
        {
            background-color: #FFFFFF;
            margin: 0px;  /* this affects the margin on the html before sending to printer */
        }

        body
        {
            border: solid 1px #ffffff ;
            margin: 10mm 10mm 10mm 10mm; /* margin you want for the content */
        }
    </style>
</head>
<body>
<div style="width:980px;padding:19px; text-align:center; border: 10px solid #787878;margin:0 auto">
    <div style="width:910px; padding:15px; text-align:center; border: 5px solid #787878">

        <span style="font-size:25px;font-weight:bold"><img src="../img/ntdc_logo.png" class="p-2" alt="NTDC logo" width="70" height="72">National Transmission & Despatch Company</span>
        <br><br>
        <span class="text-danger" style="font-size:50px; font-weight:bold">Certificate of Completion</span>
        <br><br>
        <span style="font-size:20px"><i>This is to certify that</i></span>
        <br><br>
        <span style="font-size:30px"><b>
               @php
                   $userId=Request::route('cid');
                   $name=DB::table('trainees')->where('tid',$userId)->value('name');
                   echo $name;
               @endphp
           </b></span><br/><br/>
        <span style="font-size:25px"><i>has <small class="text-success">successfully</small> completed the course</i></span> <br/><br/>
        <span style="font-size:23px">
           @php
               $userId=Request::route('cid');
               $lid=DB::table('trainees')->where('tid',$userId)->value('letterid');
             $userData = DB::table('create_letter')
                     ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
                     ->where('create_letter.letterid',$lid)
                     ->get();
               echo $userData[0]->cdesc;
           @endphp
       </span> <br/><br/> <br/>
        <span style="font-size:25px"><i>
                @php
                    $userId=Request::route('cid');
                    $lid=DB::table('trainees')->where('tid',$userId)->value('letterid');
                  $userData = DB::table('create_letter')
                     ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
                     ->where('create_letter.letterid',$lid)
                     ->get();
                    echo "(From ". date("d-m-Y", strtotime($userData[0]->sdate))." to ". date("d-m-Y", strtotime($userData[0]->edate)).")";
                @endphp
           </i></span><br><br><br>
        <div class="d-flex justify-content-between text-blue pt-5">
            <div>
                @php
                    $userId=Request::route('cid');
                       $lid=DB::table('trainees')->where('tid',$userId)->value('letterid');
                     $userData = DB::table('create_letter')
                        ->join('add_courses', 'create_letter.course', '=', 'add_courses.cid')
                        ->where('create_letter.letterid',$lid)
                        ->get();
                      echo "Date:  ". date("d-m-Y", strtotime($userData[0]->edate));
                @endphp
            </div>
            <div>
                -------------------------
                <br>
                Chief Information Officer
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/app.js')}}"></script>
</body>
</html>
