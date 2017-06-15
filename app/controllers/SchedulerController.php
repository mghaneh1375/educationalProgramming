<?php

include_once 'jdate.php';

class SchedulerController extends BaseController {
    
    public function addSchedule() {
        return $this->callViewAddScheduler('', '', '', '', '', '');
    }

    private function callViewAddScheduler($selectedUser, $selectedInterval, $selectedQuiz, $payStatus, $intervalLength, $msg) {

        $level = makeValidInput(Session::get('level', '2'));
        $userId = makeValidInput(Session::get('uId', '-1'));

        $timezone = 0;
        $now = date("Y-m-d", time()+$timezone);
        $time = date("H:i:s", time()+$timezone);
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $jalali_date = jdate("Y/m/d",$timestamp);

        $subStr = explode('/', $jalali_date);
        $year = $subStr[0];
        $month = $subStr[1];
        if($month[0] == '0')
            $month = $month[1];
        $day = $subStr[2];
        if($day[0] == '0')
            $day = $day[1];

        $week = 5;

        if($day < 8)
            $week = 1;
        else if($day < 15)
            $week = 2;
        else if($day < 22)
            $week = 3;
        else if($day < 29)
            $week = 4;

        if($level == 1) {
            $stds = Student::select('student.id')->get();
            if(count($stds) == 0)
                $users[0] = array(-1, 'دانش آموزی وجود ندارد');
            else {
                $counter = 0;
                $users = array();
                foreach ($stds as $std) {
                    $user = User::where('id', '=', $std->id)->select('user.username')->get();
                    $users[$counter++] = array($std->id, $user[0]->username);
                }
            }
        }

        else {
            $uId = Session::get('uId', '-1');
            $stds = Student::where('adviserId', '=', $uId)->select('student.id')->get();
            if(count($stds) == 0)
                $users[0] = array(-1, 'دانش آموزی وجود ندارد');
            else {
                $counter = 0;
                $users = array();
                foreach ($stds as $std) {
                    $user = User::where('id', '=', $std->id)->select('user.username')->get();
                    $users[$counter++] = array($std->id, $user[0]->username);
                }
            }
        }

        $intervals = Interval::all();

        $quizes = Quiz::select('quiz.id', 'quiz.name')->get();

        return View::make('addScheduler', array('users' => $users, 'quizes' => $quizes, 'intervals' => $intervals, 'selectedUser' => $selectedUser,
            'selectedInterval' => $selectedInterval, 'selectedQuiz' => $selectedQuiz, 'userId' => $userId, 'level' => $level,
            'payStatus' => $payStatus, 'intervalLength' => $intervalLength, 'year' => $year, 'month' => $month, 'week' => $week,
            'msg' => $msg));
    }

    public function doAddSchedule() {
        
        if(isset($_POST['addNewSchedule'])) {
            $title = makeValidInput(Input::get('year')) . makeValidInput(Input::get('month')) . makeValidInput(Input::get('week'));
            $selectedUser = makeValidInput(Input::get('selectedUser'));
            $selectedQuiz = makeValidInput(Input::get('selectedQuiz'));
            $step = makeValidInput(Input::get('step'));
            $payStatus = makeValidInput(Input::get('payStatus'));
            $intervalLength = makeValidInput(Input::get('intervalLength'));

            $level = makeValidInput(Session::get('level', '2'));

            if($payStatus != 1 && $level != 1)
                $msg = 'مادامی که وضعیت پرداخت، پرداخت نشده است، برنامه ریزی امکان ندارد';

            else {
                try {
                    $schedule = new Schedule();
                    $schedule->title = $title;
                    $schedule->userId = $selectedUser;
                    $schedule->intervalId = 1;
                    $schedule->payStatus = $payStatus;
                    $schedule->adviserId = makeValidInput(Session::get('uId', '-1'));
                    $schedule->step = $step;
                    $schedule->quizId = $selectedQuiz;

                    $schedule->save();

                    $currTime = 6;
                    $counter = 0;
                    $intervalLength = 90;
                    $intervalLength = ($intervalLength * 1.0) / 60.0;
                    while ($currTime < 24) {
                        $currTime += $intervalLength;
                        $counter++;
                    }

                    $defaultTag = Tag::take(1)->select("Tag.id")->get();
                    $defaultSubject = Assign::where("quizId", "=", 4)->take(1)->select("Assign.subjectId")->get();

                    $counter *= 7;
                    for($i = 0; $i < $counter; $i++) {
                        $scheduleItem = new ScheduleItems();
                        $scheduleItem->counter = $i;
                        $scheduleItem->subjectId = $defaultSubject[0]->subjectId;
                        $scheduleItem->tagId = $defaultTag[0]->id;
                        $scheduleItem->scheduleId = $schedule->id;
                        $scheduleItem->save();
                    }
                    return Redirect::to('schedule=' . $schedule->id);
                } catch (Exception $x) {
                    echo $x;
                    $msg = 'برنامه ای با همین عنوان برای این دانش آموز در سیستم موجود است';
                }
            }
        }

        else if(isset($_POST["seeSchedule"])) {
            $sId = makeValidInput($_POST["scheduleId"]);
            return Redirect::to('schedule=' . $sId);
        }
        
        return $this->callViewAddScheduler($selectedUser, $intervalLength, $selectedQuiz, $payStatus, $intervalLength, $msg);
    }

    public function schedule($schedulerId){

        $schedule = Schedule::where('id', '=', $schedulerId)->get();
        if (count($schedule) == 0)
            return 'مشکلی در نمایش برنامه به وجود آمده است (خطای 104)';

        $schedule = $schedule[0];

        $level = makeValidInput(Session::get('level', '3'));

        $intervalLength = Interval::where('id', '=', $schedule->intervalId)->select('intervalLength.minutes')->get()[0]->minutes;
        $tagOut = array();
        $subjects = array();

        if ($level == 1 || $level == 2) {
            $tags = Tag::all();

            $counter = 0;
            foreach ($tags as $tag)
                $tagOut[$counter++] = array($tag->id, $tag->tag);

            $conditions = ['quizId' => $schedule->quizId, 'step' => $schedule->step];
            $subjectIds = Assign::where($conditions)->select('assign.subjectId')->get();

            $counter = 0;
            for ($i = 0; $i < count($subjectIds); $i++) {
                $subject = Subject::where('id', '=', $subjectIds[$i]->subjectId)->get();
                $subjects[$counter++] = array($subject[0]->id, $subject[0]->name, $subject[0]->pageStart, $subject[0]->pageEnd);
            }

            return View::make('schedule', array('level' => $level, 'tags' => $tagOut, 'subjects' => $subjects, 'intervalLength' => $intervalLength, 'scheduleId' => $schedule->id, 'quizId' => $schedule->quizId, 'step' => $schedule->step));
        }

        return View::make('schedule', array('level' => $level, 'tags' => $tagOut, 'subjects' => $subjects, 'intervalLength' => $intervalLength, 'scheduleId' => $schedule->id));
    }
}
