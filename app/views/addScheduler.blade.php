@extends('layouts.menu')

@section('title')
    ساخت برنامه ی جدید
@stop

@section('extraLibraries')
    <script src="{{URL::asset('js/ajaxHandler.js')}}"></script>
@stop

@section('reminder')

    <script>

        var userId = "{{$userId}}";
        var level = "{{$level}}";

        $(document).ready(function () {

            $qId = $("#quiz").find(":selected").val();
            changeQuiz($qId, 'step');
            getMySchedules(userId, "schedules", level);
        });

    </script>

    <div class="myRegister" style="margin-top: 130px">
        <div class="row data">

            <div class="col-xs-12">
                <center>
                    <h3>مشاهده ی برنامه های من</h3>
                </center>
                <div class="line"></div>

                <center>
                    <form method="post" action="{{ htmlspecialchars($_SERVER['PHP_SELF']) }}">
                        <div class="col-xs-12">
                            <label>
                                <span>برنامه های من</span>
                                <select name="scheduleId" id="schedules">
                                </select>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <input type="submit" class="MyBtn" style="width: auto" name="seeSchedule" value="مشاهده ی برنامه">
                        </div>
                    </form>
                </center>
            </div>

            @if($level == 1 || $level == 2)
                <div class="col-xs-12">
                <center>
                    <h3>ساخت برنامه ی جدید</h3>
                </center>
                <div class="line"></div>
                <form method="post" action="{{ htmlspecialchars($_SERVER['PHP_SELF']) }}">
                    <center>


                        <div class="col-xs-12">
                            <label>
                                <span>سال</span>
                                <?php $i = 1396; ?>
                                <select name="year">
                                    @while($i < 1401)
                                        @if($year == $i)
                                            <option value="{{$i}}" selected>{{$i}}</option>
                                        @else
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endif
                                        <?php $i++; ?>
                                    @endwhile
                                </select>
                            </label>
                        </div>

                        <?php $months = ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"]  ?>

                        <div class="col-xs-12">
                            <label>
                                <span>ماه</span>
                                <?php $i = 1; ?>
                                <select name="month">
                                    @while($i < 13)
                                        @if($month == $i)
                                            <option value="{{$i}}" selected>{{$months[$i - 1]}}</option>
                                        @else
                                            <option value="{{$i}}">{{$months[$i - 1]}}</option>
                                        @endif
                                        <?php $i++; ?>
                                    @endwhile
                                </select>
                            </label>
                        </div>

                        <?php $weeks = ['اول', 'دوم', 'سوم', 'چهارم', 'پنجم']; ?>

                        <div class="col-xs-12">
                            <label>
                                <span>هفته ی </span>
                                <?php $i = 1; ?>
                                <select name="week">
                                    @while($i < 5)
                                        @if($week == $i)
                                            <option value="{{$i}}" selected>{{$weeks[$i - 1]}}</option>
                                        @else
                                            <option value="{{$i}}">{{$weeks[$i - 1]}}</option>
                                        @endif
                                        <?php $i++; ?>
                                    @endwhile
                                </select>
                            </label>
                        </div>

                        <div class="col-xs-12">
                            <label>
                                <span>آزمون مورد نظر</span>
                                <select id="quiz" name="selectedQuiz" onchange="changeQuiz(this.value, 'step')">
                                    @foreach($quizes as $quiz)
                                        @if($selectedQuiz == $quiz->id)
                                            <option selected value="{{$quiz->id}}">{{$quiz->name}}</option>
                                        @else
                                            <option value="{{$quiz->id}}">{{$quiz->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="col-xs-12">
                            <label>
                                <span>مرحله ی آزمون</span>
                                <select name="step" id="step"></select>
                            </label>
                        </div>

                        <div class="col-xs-12">
                            <label>
                                <span>نام کاربری دانش آموز مورد نظر</span>
                                <select name="selectedUser">
                                    @foreach($users as $user)
                                        @if($selectedUser == $user[0])
                                            <option selected value="{{$user[0]}}">{{$user[1]}}</option>
                                        @else
                                            <option value="{{$user[0]}}">{{$user[1]}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="col-xs-12">
                            <label>
                                <span>وضعیت پرداخت</span>
                                <select name="payStatus">
                                    @if($payStatus == 1)
                                        <option value="1" selected>پرداخت شده</option>
                                        <option value="0">پرداخت نشده</option>
                                    @else
                                        <option value="1">پرداخت شده</option>
                                        <option value="0" selected>پرداخت نشده</option>
                                    @endif
                                </select>
                            </label>
                        </div>

                        <div class="col-xs-12">
                            <label>
                                <span>طول بازه ها</span>
                                <select name="intervalLength">
                                    @foreach($intervals as $interval)
                                        @if($selectedInterval == $interval->id)
                                            <option selected value="{{$interval->id}}">{{$interval->minutes}} دقیقه</option>
                                        @else
                                            <option value="{{$interval->id}}">{{$interval->minutes}} دقیقه</option>
                                        @endif
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <center class="warning_color">{{$msg}}</center>
                        <input type="submit" class="MyBtn" style="width: auto; padding: 5px; margin-top: 30px" name="addNewSchedule" value="برو به مرحله ی بعد">
                    </center>
                </form>
            </div>
            @endif
        </div>
    </div>
@stop