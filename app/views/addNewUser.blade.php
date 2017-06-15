@extends('layouts.menu')

@section('title')
    اضافه کردن کاربر چدید
@stop

@section('reminder')
    <center style="margin-top: 130px">
        @if($mode == 'student')
            <center>
                <h3>دانش آموز جدید</h3>
                <div class="line"></div>
            </center>
            <form method="post" action="{{URL('addStudent')}}">
                <div class="myRegister">
                    <div class="row data">
                        @include('layouts.newUserForm')
                        <center>
                            <div class="col-xs-12">
                                <label>
                                    <span>chat id</span>
                                    <input type="text" name="chatId" value="{{$chatId}}">
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label>
                                    <span>شماره ی همراه ولی</span>
                                    <input type="text" name="parentPhoneNum" value="{{$parentPhoneNum}}" maxlength="11" required>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label>
                                    <span>پایه ی تحصیلی</span>
                                    <select name="selectedDegree">
                                        @foreach($degrees as $degree)
                                            @if($selectedDegree == $degree->id)
                                                <option selected value="{{$degree->id}}">{{$degree->degree}}</option>
                                            @else
                                                <option value="{{$degree->id}}">{{$degree->degree}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label>
                                    <span>ایمیل</span>
                                    <input type="email" name="email" value="{{$email}}" maxlength="40">
                                </label>
                            </div>

                            <center class="warning_color">{{$msg}}</center>
                            <input type="submit" class="MyBtn" style="width: auto; padding: 5px; margin-top: 30px" name="addNewStudent" value="تایید">
                        </center>
                    </div>
                </div>
            </form>
        @else
            <center>
                <h3>مشاور جدید</h3>
                <div class="line"></div>
            </center>
            <div class="myRegister">
                <div class="row data">
                    <form method="post" action="{{ htmlspecialchars($_SERVER['PHP_SELF']) }}">
                        @include('layouts.newUserForm')
                        <center class="warning_color">{{$msg}}</center>
                        <input type="submit" class="MyBtn" style="width: auto; padding: 5px; margin-top: 30px" name="addNewAdviser" value="تایید">
                    </form>
                </div>
            </div>
        @endif
    </center>
@stop
{{--298697135:AAG1sTtuaXGvxand-KMonqUl8rkzt_He0rw--}}