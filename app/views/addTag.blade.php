@extends('layouts.menu')

@section('title')
    مشاهده ی تگ ها
@stop

@section('reminder')
    <div class="myRegister" style="margin-top: 130px">
        <div class="row data">
            <center>
                <h3>تگ ها</h3>
            </center>
            <div class="line"></div>
            <center>
                <form method="post" action="{{ htmlspecialchars($_SERVER['PHP_SELF']) }}">
                    @foreach($tags as $t)
                        <div class="col-xs-12">
                            <label>
                                <span>{{$t->tag}}</span>

                                @if($t->programmable)
                                    <span>قابل برنامه ریزی</span>
                                @else
                                    <span>غیر قابل برنامه ریزی</span>
                                @endif

                                <button style="margin-right: 5px" class="btn btn-danger" name="deleteSelected" value="{{$t->id}}" data-toggle="tooltip" title="حذف تگ">
                                    <span style="margin-left: 10%" class="glyphicon glyphicon-remove"></span>
                                </button>
                            </label>
                        </div>
                    @endforeach
                </form>

                <center style="margin-top: 10px" class="warning_color">{{$msg}}</center>
                <form method="post" action="{{ htmlspecialchars($_SERVER['PHP_SELF']) }}">
                    <div class="col-xs-12">
                        <label>
                            <span>تگ جدید</span>
                            <input type="text" name="tag" value="{{$tag}}" maxlength="40" autofocus>
                        </label>
                    </div>
                    <div class="col-xs-12">
                        <label>
                            <span> قابلیت برنامه ریزی را داشته باشد</span>
                            <input type="checkbox" name="programmable">
                        </label>
                    </div>
                <input type="submit" class="MyBtn" style="width: auto; padding: 5px; margin-top: 30px" name="addNewTag" value="اضافه کن">
                </form>
            </center>
        </div>
    </div>
@stop