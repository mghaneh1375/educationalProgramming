@extends('layouts.menu')

@section('title')
    آزمون ها
@stop

@section('reminder')

    <div class="myRegister" style="margin-top: 130px">
        <center class="row data">
            <form method="post" action="{{htmlspecialchars($_SERVER["PHP_SELF"])}}">
                @if($mode == 'see')
                    <center>
                        <h3>آزمون ها</h3>
                    </center>
                    <div class="line"></div>
                    <div class="col-xs-12">
                        <label>
                            <span>نام آزمون</span>
                            <input type="text" name="quizName" maxlength="20" autofocus>
                        </label>
                    </div>
                    <div class="col-xs-12">
                        <label>
                            <span>تعداد مراحل آزمون</span>
                            <input type="number" name="steps" value="1" min="1" max="100">
                        </label>
                    </div>

                    <div class="col-xs-12">
                        <center class="warning_color">{{$msg}}</center>
                        <input type="submit" class="MyBtn" style="width: auto; padding: 5px; margin-top: 30px" name="addNewQuiz" value="اضافه کن">
                    </div>

                    @foreach($quizes as $quiz)
                        <div class="col-xs-12">
                            <label>
                                <span>{{$quiz->name}}</span>
                                <button style='margin-right: 5px' class='btn btn-danger' name='deleteSelected' value='{{$quiz->id}}' data-toggle='tooltip' title='حذف آزمون'>
                                    <span style='margin-left: 10%' class='glyphicon glyphicon-remove'></span>
                                </button>
                                <button style='margin-right: 5px' class='btn btn-info' name='editSelected' value='{{$quiz->id}}' data-toggle='tooltip' title='ویرایش آزمون'>
                                    <span style='margin-left: 10%' class='glyphicon glyphicon-edit'></span>
                                </button>
                            </label>
                        </div>
                    @endforeach

                @else
                    <center>{{$quiz->name}}</center>
                    <div class="col-xs-12">
                        <label>
                            <span>نام جدید آزمون</span>
                            <input type="text" value="{{$quiz->name}}" name="newQuizName" maxlength="20" autofocus>
                            <input type="text" value="{{$quiz->id}}" name="quizId" hidden>
                        </label>
                    </div>
                    <div class="col-xs-12">
                        <center class="warning_color">{{$msg}}</center>
                        <input type="submit" class="MyBtn" style="width: auto" name="doEditQuiz" value="اعمال تغییر">
                    </div>
                    <?php $i = 1; ?>
                    @while($i <= $quiz->steps)
                        <div class="col-xs-12">
                            <span> مرحله ی {{$i}}</span>

                            <button style='margin-right: 5px' class='btn btn-danger' name='deleteSelectedStep' value='{{$i}}' data-toggle='tooltip' title='حذف مرحله'>
                                <span style='margin-left: 10%' class='glyphicon glyphicon-remove'></span>
                            </button>
                        </div>
                        <?php $i++; ?>
                    @endwhile
                @endif
                <div class="col-xs-12">
                    <center>
                        <button style='margin-right: 5px' class='btn btn-info' name='addNewStep' data-toggle='tooltip' title='اضافه کردن مرحله جدید'>
                            <span style='margin-left: 10%' class='glyphicon glyphicon-plus'></span>
                        </button>
                    </center>
                </div>
            </form>
        </center>
    </div>
@stop