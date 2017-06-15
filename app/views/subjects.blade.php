@extends('layouts.menu')

@section('title')
    مباحث
@stop

@section('extraLibraries')
    <script src = "{{URL::asset('js/ajaxHandler.js')}}"></script>
@stop

@section('reminder')
    <div class="myRegister" style="margin-top: 130px">
        <div class="row data">
            <center>
                @if($mode == 'see')
                    <script>
                        var selectedLesson = "{{$selectedLesson}}";
                        $(document).ready(function () {
                            did = $('#degree').find(':selected').val();
                            generalChangeDegree(did, 'lesson', 2, selectedLesson, 'subject', 2);
                        });
                        function changeDegreeLocal(did) {
                            generalChangeDegree(did, 'lesson', 2, selectedLesson, 'subject', 2);
                        }
                    </script>

                    <form method="post" action="{{htmlspecialchars($_SERVER["PHP_SELF"])}}">
                        <div class="col-xs-12">
                            <label>
                                <span>پایه ی تحصیلی مورد نظر</span>
                                <select name="selectedDegree" id="degree" onchange="changeDegreeLocal(this.value)">
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
                                <span>درس مورد نظر</span>
                                <select name="selectedLesson" id="lesson" onchange="generalChangeLesson(this.value, 'subject', 2)"></select>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>نام مبحث جدید</span>
                                <input type="text" name="subject" value="{{$subjectName}}" autofocus maxlength="40">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>از صفحه ی</span>
                                <input type="number" min="1" max="300" name="pageStart" value="{{$pageStart}}">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>تا صفحه ی</span>
                                <input type="number" min="1" max="300" name="pageEnd" value="{{$pageEnd}}">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <center class="warning_color">{{$msg}}</center>
                            <input type="submit" name="addNewSubject" class="MyBtn" style="width: auto" value="اضافه کن">
                        </div>

                        <div class="col-xs-12" id="subject">
                        </div>
                    </form>

                @elseif($mode == 'edit')
                    <script>
                        var selectedLesson = "{{$selectedLesson}}";
                        $(document).ready(function () {
                            did = $('#degree2').find(':selected').val();
                            generalChangeDegree(did, 'lesson2', 2, '', -1);
                        });
                        function changeDegreeLocal2(did) {
                            generalChangeDegree(did, 'lesson2', 2, '', -1);
                        }
                    </script>
                    <form method="post" action="{{htmlspecialchars($_SERVER["PHP_SELF"])}}">
                        <div class="col-xs-12">
                            <label>
                                <span>پایه ی تحصیلی جدید مورد نظر</span>
                                <select id="degree2" name="newSelectedDegree" onchange="changeDegreeLocal2(this.value)">
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
                                <span>درس مورد نظر</span>
                                <select id="lesson2" name="newSelectedLesson"></select>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>نام جدید مبحث</span>
                                <input type="text" name="newSubjectName" value="{{$name}}" autofocus required maxlength="40">
                                <input type="text" hidden name="selectedSubject" value="{{$selectedSubject}}">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>از صفحه ی</span>
                                <input type="number" min="1" max="300" name="pageStart" value="{{$pageStart}}">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label>
                                <span>تا صفحه ی</span>
                                <input type="number" min="1" max="300" name="pageEnd" value="{{$pageEnd}}">
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <center class="warning_color">{{$msg}}</center>
                            <input type="submit" name="doEditSubject" class="MyBtn" style="width: auto" value="تایید">
                        </div>
                    </form>
                @endif
            </center>
        </div>
    </div>
@stop