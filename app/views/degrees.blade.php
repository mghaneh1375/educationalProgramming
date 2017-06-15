@extends('layouts.menu')

@section('title')
    پایه های تحصیلی
@stop

@section('reminder')
    <div class="myRegister" style="margin-top: 130px">
        <div class="row data">
            <center>
                @if($mode == 'see')
                    <form method="post" action="{{htmlspecialchars($_SERVER["PHP_SELF"])}}">
                        <div class="col-xs-12">
                            <label>
                                <span>نام پایه</span>
                                <input type="text" name="degree" maxlength="40" autofocus>
                            </label>
                        </div>

                        <center class="warning_color">{{$msg}}</center>
                        <input type="submit" class="MyBtn" style="width: auto; padding: 5px; margin-top: 30px" name="addNewDegree" value="اضافه کن">
                        @foreach($degrees as $degree)
                            <div class="col-xs-12">

                                <span>{{$degree->degree}}</span>

                                <button style="margin-right: 5px" class="btn btn-info" name="editSelected" value="{{$degree->id}}" data-toggle="tooltip" title="ویرایش پایه ی تحصیلی">
                                    <span style="margin-left: 10%" class="glyphicon glyphicon-edit"></span>
                                </button>

                                <button style="margin-right: 5px" class="btn btn-danger" name="deleteSelected" value="{{$degree->id}}" data-toggle="tooltip" title="حذف پایه ی تحصیلی">
                                    <span style="margin-left: 10%" class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        @endforeach
                    </form>
                @else
                    <form method="post" action="{{htmlspecialchars($_SERVER["PHP_SELF"])}}">
                        <div class="col-xs-12">
                            <span>نام پایه : </span>
                            <span>{{$dN}}</span>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>نام جدید پابه</span>
                                <input type="text" name="newDegree" required maxlength="40">
                                <input type="text" name="did" value="{{$did}}" hidden>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <p class="warning_color">{{$msg}}</p>
                            <input type="submit" name="doEdit" value="تایید" class="MyBtn" style="margin-top: 10px; width: auto">
                        </div>
                    </form>
                @endif
            </center>
        </div>
    </div>
@stop