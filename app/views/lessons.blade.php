@extends('layouts.menu')

@section('title')
    دروس
@stop

@section('extraLibraries')
    <script>
        $(document).ready(function () {
            did = $('#degree').find(':selected').val();
            generalChangeDegree(did, 'lesson', 1, -1, '', -1);
        });
    </script>
    <script src = "{{URL::asset('public/js/ajaxHandler.js')}}"></script>
@stop

@section('reminder')
    <div class="myRegister" style="margin-top: 130px">
        <div class="row data">
            <center>
                @if($mode == 'see')
                    <form method="post" action="{{URL('lessons')}}" enctype="multipart/form-data">
                        <div class="col-xs-12">
                            <label>
                                <span>پایه ی تحصیلی مورد نظر</span>
                                <select name="selectedDegree" id="degree" onchange="generalChangeDegree(this.value, 'lesson', 1, -1, '', -1)">
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
                                <span>نام درس</span>
                                <input type="text" name="lesson" autofocus maxlength="40">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <center class="warning_color">{{$msg}}</center>
                            <input type="submit" name="addNewLesson" class="MyBtn" style="width: auto" value="اضافه کن">
                        </div>

                        <div class="col-xs-12" style="margin-top: 20px">
                            <input type="file" name="batchLessons">
                        </div>

                        <div class="col-xs-12">
                            <input type="submit" name="addBatch" class="MyBtn" style="width: auto" value="اضافه کردن دسته ای دروس">
                        </div>

                        <div class="col-xs-12" id="lesson">
                        </div>
                    </form>

                @elseif($mode == 'edit')
                    <form method="post" action="{{URL('lessons')}}">
                        <div class="col-xs-12">
                            <label>
                                <span>پایه ی تحصیلی جدید مورد نظر</span>
                                <select name="newSelectedDegree">
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
                                <span>نام جدید درس</span>
                                <input type="text" name="newLessonName" value="{{$name}}" autofocus required maxlength="40">
                                <input type="text" hidden name="selectedLesson" value="{{$selectedLesson}}">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <center class="warning_color">{{$msg}}</center>
                            <input type="submit" name="doEditLesson" class="MyBtn" style="width: auto" value="تایید">
                        </div>
                    </form>
                @endif
            </center>
        </div>
    </div>
@stop