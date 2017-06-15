@extends('layouts.menu')

@section('title')
    آزمون ها
@stop

@section('extraLibraries')
    <script>

        $(document).ready(function () {
            quiz =  $("#quiz").find(":selected").val();
            did = $("#degree").find(":selected").val();
            generalChangeDegree(did, 'lesson', 2, -1, 'subject', 1);
            changeQuiz(quiz, 'selectedStage', 'subjects');
        });

        function changeStageLocal(step) {
            quiz =  $("#quiz").find(":selected").val();
            changeStage(quiz, step, 'subjects');
        }

        function changeDegreeLocal(did) {
            generalChangeDegree(did, 'lesson', 2, -1, 'subject', 1);
        }

        function addNewAssignLocal() {
            quiz =  $("#quiz").find(":selected").val();
            step =  $("#selectedStage").find(":selected").val();
            sid =  $("#subject").find(":selected").val();
            addNewAssign(quiz, step, sid);
            changeStage(quiz, step, 'subjects');
        }


    </script>

    <script src="{{URL::asset('js/ajaxHandler.js')}}"></script>
@stop

@section('reminder')

    <div class="myRegister" style="margin-top: 130px">
        <center class="row data">
            <center>
                <h3>آزمون ها</h3>
            </center>
            <div class="line"></div>
            <div class="col-xs-12">
                <label style="margin-top: 10px">
                    <span>آزمون مورد نظر</span>
                    <select id="quiz" onchange="changeQuiz(this.value, 'selectedStage', 'subjects')">
                        @foreach($quizes as $quiz)
                            <option value="{{$quiz->id}}">{{$quiz->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="col-xs-12">
                <label>
                    <span>مرحله ی مورد نظر</span>
                    <select id="selectedStage" onchange="changeStageLocal(this.value)">
                    </select>
                </label>
            </div>
            <div class="col-xs-12" id="subjects">
            </div>

            <div class="col-xs-12">
                <h4>افزودن مبحث به آزمون</h4>
                <div class="line"></div>
            </div>
            <div class="col-xs-12">
                <label>
                    <span>پایه ی مورد نظر</span>
                    <select id="degree" onchange="changeDegreeLocal(this.value)">
                        @foreach($degrees as $degree)
                            <option value="{{$degree->id}}">{{$degree->degree}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="col-xs-12">
                <label>
                    <span>درس مورد نظر</span>
                    <select id="lesson" onchange="generalChangeLesson(this.value, 'subject', 1)"></select>
                </label>
            </div>
            <div class="col-xs-12">
                <label>
                    <span>مبحث مورد نظر</span>
                    <select id="subject"></select>
                </label>
            </div>
            <div class="col-xs-12">
                <div class="warning_color" id="msg"></div>
                <input type="submit" class="MyBtn" onclick="addNewAssignLocal()" style="width: auto; padding: 5px; margin-top: 30px" value="اضافه کن">
            </div>
        </center>
    </div>
@stop