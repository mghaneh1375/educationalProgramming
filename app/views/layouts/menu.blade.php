<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.mainLibraries')
    @yield('extraLibraries')
    <title>@yield('title')</title>
</head>

<?php $level = makeValidInput(Session::get('level')) == '1'; ?>

<body class="main">
<div class="container" style="height: 100vh; margin-top: 10px">
    <div class="row">
        <div class="col-xs-12 col-md-3 col-md-push-9" style="height: auto">
            <center style="cursor: pointer; margin-top: 10px; margin-bottom: 10px">
                <div style="width: 100%">
                    <img class="circling" style="width: 100%; height: 150px" src={{URL::asset('public/images/logo.png')}}>
                </div>
            </center>

            <a style="color: black; float: right" data-toggle="tooltip" title="خانه" href="{{URL('home')}}">
                <button type="submit" style="background-color: transparent; border: none">
                    <span style="margin-left: 10%; color: #61108e" class="glyphicon glyphicon-home"></span>
                </button>
            </a>

            @if($level == 1)
                <a style="color: black" href="{{URL('addAdviser')}}"><button type="submit" class="MyBtn">اضافه کردن مشاور جدید</button></a>
                <a style="color: black" href="{{URL('tag')}}"><button type="submit" class="MyBtn">تگ ها</button></a>
                <a style="color: black" href="{{URL('quizes')}}"><button type="submit" class="MyBtn">آزمون ها</button></a>
                <a style="color: black" href="{{URL('stages')}}"><button type="submit" class="MyBtn">مراحل آزمون ها</button></a>
                <a style="color: black" href="{{URL('grades')}}"><button type="submit" class="MyBtn">پایه های تحصیلی</button></a>
                <a style="color: black" href="{{URL('lessons')}}"><button type="submit" class="MyBtn">درس ها</button></a>
                <a style="color: black" href="{{URL('subjects')}}"><button type="submit" class="MyBtn">زیر مبحث ها</button></a>

            @elseif($level == 2)
                <a style="color: black" href="{{URL('addStudent')}}"><button type="submit" class="MyBtn">اضافه کردن دانش آموز جدید</button></a>
            @endif


            <a style="color: black" href="{{URL('schedules')}}"><button type="submit" class="MyBtn  zoomCA">برنامه ها</button></a>
            <a style="color: black" href="{{URL('logout')}}"><button type="submit" class="MyBtn">خروج</button></a>

        </div>
        <div class="col-xs-12 col-md-9 col-md-pull-3 sideBar">
            @yield('reminder')
        </div>
    </div>
</div>
</body>
</html>