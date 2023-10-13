<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TSG Training Portal</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{ asset('img/admin.png') }}">
    <style type="text/css">
        .table-dark {
            color: #fff;
            background-color: #663300;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #FF860D;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->


        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars fa-2x"></i></a>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a href="/logout" class="nav-link m-0 p-1">
                    <i class="nav-icon fas fa-power-off red"></i>
                    Logout
                </a>
            </li>
        </ul>

    </nav>
{{--Right most side menu bar--}}

<!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="img/admin.png" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            @if(isset(Auth::user()->user_type))
                <span class="brand-text text-capitalize">{{Auth::user()->user_type}}</span>
            @elseif(!empty(session('external')))
                    <span class="brand-text text-sm">External Trainee</span>
            @elseif(empty(session('external')))
                    <span class="brand-text text-sm">{{session('useremail')[0].'@'.session('useremail')[1]}}</span>
            @elseif(isset($personalData))
                @if(!empty($personalData[0]->Name))
                    <span class="brand-text text-sm">{{$personalData[0]->Name}}</span>
                @elseif(!empty($personalData[0]->name))
                    <span class="brand-text text-sm">{{$personalData[0]->name}}</span>
                @endif
            @endif
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel d-flex">
                <div class="image">
                    <img src="img/boss.png" class="img-circle elevation-2" alt="User Image">
                </div>
                @if(!empty(session('username')))
                    <div class="info">
                        <a href="#" class="d-block text-capitalize text-sm py-1">{{session('username')}}</a>
                    </div>
                @endif
                @if(isset(Auth::user()->name))
                    <div class="info">
                        <a href="#" class="d-block text-capitalize py-1">{{Auth::user()->name}}</a>
                    </div>
                @endif
            </div>

            <!-- Sidebar Menu -->
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @if(empty(session('username')))
                        <li class="nav-item">
                            <a href="/home" class="nav-link  m-1 p-1">
                                <i class="nav-icon fas fa-home blue"></i>
                                Home
                            </a>
                        </li>
                    @endif

                    @if(!empty(session('username')))
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <li class="nav-item">
                                    @isset($outsider)
                                        @if(!strcmp($outsider,'yes'))
                                            <router-link to="/dashboard/{{session('useremail')}}" class="nav-link animated pulse delay-2s infinit">
                                                <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                                                <p class="text-white h5">
                                                    Dashboard
                                                </p>
                                            </router-link>
                                        @else
                                            <router-link to="/dashboard/{{session('useremail')[0].'@'.session('useremail')[1]}}" class="nav-link animated pulse delay-2s infinit">
                                                <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                                                <p class="text-white h5">
                                                    Dashboard
                                                </p>
                                            </router-link>
                                        @endif
                                    @endisset
                                </li>
                                @isset($not_trainee)
                                    @if(strcmp($not_trainee,'yes'))
                                        <li class="nav-item">
                                            <router-link to="/lecture/{{session('useremail')[0].'@'.session('useremail')[1]}}"
                                                         class="nav-link">
                                                <i class="nav-icon fas fa-book text-danger"></i>
                                                <p class="text-white">
                                                    Lectures
                                                </p>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link
                                                to="/pdisplay/{{session('useremail')[0].'@'.session('useremail')[1]}}"
                                                class="nav-link">
                                                <i class="nav-icon fas fa-book-reader text-blue"></i>
                                                <p>
                                                    Presentations
                                                </p>
                                            </router-link>
                                        </li>
                                    @endif
                                @endisset
                                <li class="nav-item has-treeview">
                                    <router-link to="/ind_content" class="nav-link">
                                        <i class="fas fa-arrow-right text-info nav-icon"></i>
                                        <p>Indvidual Content</p>
                                    </router-link>
                                </li>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-swatchbook"></i>
                                        <p>
                                            TSG Library
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @php
                                            $libCat=DB::table('category')->get();
                                            foreach ($libCat as $cat)
                                            {
                                              echo '<li class="nav-item">
                                                      <router-link to="/display_library/'.$cat->cid.'"
                                                                    class="nav-link">
                                                           <i class="fas fa-arrow-right nav-icon"></i>
                                                           <p>'.$cat->category.'</p>
                                                       </router-link>
                                                   </li>';
                                            }
                                        @endphp
                                    </ul>
                                </li>
                                <li class="nav-item has-treeview">
                                    <router-link to="/record_search" class="nav-link">
                                        <i class="nav-icon fas fa-history text-danger"></i>
                                        <p>
                                            Previous Courses Data
                                        </p>
                                    </router-link>
                                </li>
                            </ul>
                        </nav>
                    @endif
                    @isset($data)
                        @php
                            $user = Auth::user();
                                     $userId=$user['id'];
                                     $usertype=$user['user_type'];
                                     $useremail=$user['email'];
                                     if (strcmp($usertype,'user'))
                                         {
                                               $mId = DB::table('user_rights')->distinct()->where('uId', $userId)->pluck('mmenuId');
                                              $i=0;
                                           echo '<nav class="mt-2"><ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
                                     while ($i<count($mId)){
                                    $mmenu=DB::table('main_menus')->where('mmenuId',$mId[$i])->first();
                                    if ((!strcmp($mmenu->mmenuDesc,'User Management') || !strcmp($mmenu->mmenuDesc,'Menu Management')) && Auth::user()->user_type!=='super admin')
                                      {
                                        ++$i;
                                         continue;
                                      }
                                      else
                                      {

                                       echo '<li class="nav-item has-treeview"><router-link to="/'.$mmenu->mmenuURL.'" class="nav-link"><i class="nav-icon fas fa-chevron-circle-down"></i><p>'.$mmenu->mmenuDesc.'';
                                       echo '<i class="right fas fa-angle-left"></i></p></router-link>';
                                           $smenu=DB::table('sub_menus')->orderBy('sOrder')->where('mmenuId',$mId[$i])->get();
                                           foreach ($smenu as $sm)
                                           {
                                            $restrict=DB::table('user_rights')->distinct()->where('mmenuId',$mId[$i])->where('smenuId',$sm->smenuId)->where('uId',$userId)->value('cAdd');
                                            if ($restrict=='true')
                                             {
                                              echo '<ul class="nav nav-treeview"><li class="nav-item"><router-link to="/'.$sm->smenuURL.'" class="nav-link"> <i class="nav-icon fas fa-ellipsis-v"></i><p>'.$sm->smenuDesc.'</p></router-link> </li></ul>';
                                             }
                                            unset($sm->smenuDesc);
                                            }
                                         $i++;
                                      }
                                      }
                                 echo '</ul></nav>';
                                         }
                                     else
                                         {
                                             echo '<li class="nav-item">
                                                     <router-link to="/dashboard/'.$useremail.'" class="nav-link animated pulse delay-2s infinit">
                                                            <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                                                            <p class="text-white h5">
                                                                Dashboard
                                                            </p>
                                                        </router-link>
                                                    </li>';
                                          echo ' <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas fa-swatchbook"></i>
                                                <p>
                                                    TSG Library
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                             </a><ul class="nav nav-treeview">';
                                             $libCat=DB::table('category')->get();
                                            foreach ($libCat as $cat)
                                            {
                                              echo '<li class="nav-item">
                                                      <router-link to="/display_library/'.$cat->cid.'"
                                                                    class="nav-link">
                                                           <i class="fas fa-arrow-right nav-icon"></i>
                                                           <p>'.$cat->category.'</p>
                                                       </router-link>
                                                   </li>';
                                            }
                                            echo '</ul></li>';
                                            echo '<li class="nav-item has-treeview">
                                            <router-link to="/record_search" class="nav-link">
                                                <i class="nav-icon fas fa-history text-danger"></i>
                                                <p>
                                                    Previous Courses Data
                                                </p>
                                            </router-link>
                                         </li>';

                                         }

                        @endphp
                    @endisset


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content mt-4">
            <div class="container-fluid">

                @if(isset($personalData))
                    @if(isset($courseData) && !isset($instructorData)&& !isset($traineeData))
                        <h3 class="text-danger"><span class="badge badge-danger text-white">Existing Courses List</span>
                        </h3>
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Course Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courseData as $key=>$course)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$course->cdesc}}</td>
                                    <td>{{$course->ctitle}}</td>
                                    <td class="animated infinite pulse text-info">{{$course->sdate}}</td>
                                    <td>{{$course->edate}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @elseif(isset($courseData) && isset($instructorData)&& !isset($traineeData))
                        <h3 class="text-danger"><span class="badge badge-danger text-white">Existing Courses List</span>
                        </h3>
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Course Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courseData as $key=>$course)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$course->cdesc}}</td>
                                    <td>{{$course->ctitle}}</td>
                                    <td class="animated infinite pulse text-info">{{$course->sdate}}</td>
                                    <td>{{$course->edate}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h3 class="text-danger mt-3"><span class="badge badge-danger text-white">Course Assined To Instructor</span>
                        </h3>
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Course Title</th>
                                <th>Instructor</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($instructorData as $key=>$instructor)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$instructor->cdesc}}</td>
                                    <td>{{$instructor->ctitle}}</td>
                                    <td>{{$instructor->name}}</td>
                                    <td class="animated infinite pulse">{{$instructor->sdate}}</td>
                                    <td>{{$instructor->edate}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @elseif(isset($courseData) && !isset($instructorData)&& isset($traineeData))
                        <h3 class="text-danger"><span class="badge badge-danger text-white">Existing Courses List</span>
                        </h3>
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Course Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courseData as $key=>$course)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$course->cdesc}}</td>
                                    <td>{{$course->ctitle}}</td>
                                    <td class="animated infinite pulse">{{$course->sdate}}</td>
                                    <td>{{$course->edate}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <h3 class="text-danger mt-3"><span class="badge badge-danger text-white">Enrolled In</span></h3>
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Letter Title</th>
                                <th>Letter No</th>
                                <th>Course Title</th>
                                <th>Letter Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($traineeData as $key=>$trainee)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$trainee->name}}</td>
                                    <td>{{$trainee->ltitle}}</td>
                                    <td>{{$trainee->lno}}</td>
                                    <td>{{$trainee->ctitle}}</td>
                                    <td>{{$trainee->ldate}}</td>
                                    <td class="animated infinite pulse">{{$trainee->sdate}}</td>
                                    <td>{{$trainee->edate}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif
                @else
                    <router-view></router-view>
                @endif

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <!-- Footer -->
    <footer class="main-footer font-small blue">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-1">@php echo date("Y"); @endphp Copyright:
            <a href="http://demo.ntdc.com.pk/" class="pl-2">www.ntdc.com.pk</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->
</div>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>
