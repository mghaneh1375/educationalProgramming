<?php

include_once 'mpdf60/mpdf.php';

class ajaxHandler extends BaseController {

    public function getLessons() {

        $degreeId = makeValidInput($_POST["degreeId"]);
        $mode = makeValidInput($_POST["mode"]);
        $lessons = Degree::find($degreeId)->lessons()->get();
        if (count($lessons) == 0) {
            if ($mode == 1) {
                echo "<p>درسی موجود نیست</p>";
            } else {
                echo '<option value="-1">درسی موجود نیست</option>';
            }
            return;
        }
        if ($mode == 1) {
            foreach ($lessons as $lesson) {
                echo '<div class="col-xs-12">';
                echo "<span>" . $lesson->name . "</span>";
                echo "<button style='margin-right: 5px' class='btn btn-danger' name='deleteSelected' value='" . $lesson->id . "'' data-toggle='tooltip' title='حذف درس'>
                            <span style='margin-left: 10%' class='glyphicon glyphicon-remove'></span>
                </button>";
                echo "<button style='margin-right: 5px' class='btn btn-info' name='editSelected' value='" . $lesson->id . "'' data-toggle='tooltip' title='ویرایش درس'>
                            <span style='margin-left: 10%' class='glyphicon glyphicon-edit'></span>
                </button>";
                echo '</div>';
            }
        } else {
            $selectedLesson = -1;
            if (isset($_POST['selectedLesson']))
                $selectedLesson = makeValidInput($_POST['selectedLesson']);
            foreach ($lessons as $lesson) {
                if ($lesson->id == $selectedLesson)
                    echo "<option selected value='" . $lesson->id . "'>" . $lesson->name . "</option>";
                else
                    echo "<option value='" . $lesson->id . "'>" . $lesson->name . "</option>";
            }
        }
    }

    public function getSubjects()
    {
        $lessonId = makeValidInput($_POST["lessonId"]);
        if ($lessonId == -1) {
            echo '<option value="-1">مبحثی موجود نیست</option>';
            return;
        }
        $mode = makeValidInput($_POST['mode']);
        $subjects = Lesson::find($lessonId)->subjects()->get();
        if (count($subjects) == 0) {
            echo '<option value="-1">مبحثی موجود نیست</option>';
            return;
        }
        if ($mode == 1) {
            foreach ($subjects as $subject)
                echo "<option value='" . $subject->id . "'>" . $subject->name . " (از صفحه ی " . $subject->pageStart . " تا صفحه ی  " . $subject->pageEnd . " )</option>";
        } else if ($mode == 2) {
            foreach ($subjects as $subject) {
                echo '<div class="col-xs-12">';
                echo "<span>" . $subject->name . " (از صفحه ی " . $subject->pageStart . " تا صفحه ی  " . $subject->pageEnd . " ) " . "</span>";
                echo "<button style='margin-right: 5px' class='btn btn-danger' name='deleteSelected' value='" . $subject->id . "'' data-toggle='tooltip' title='حذف مبحث'>
                            <span style='margin-left: 10%' class='glyphicon glyphicon-remove'></span>
                </button>";
                echo "<button style='margin-right: 5px' class='btn btn-info' name='editSelected' value='" . $subject->id . "'' data-toggle='tooltip' title='ویرایش مبحث'>
                            <span style='margin-left: 10%' class='glyphicon glyphicon-edit'></span>
                </button>";
                echo '</div>';
            }
        }
    }

    public function addNewAssign()
    {
        $sId = makeValidInput($_POST['subjectId']);
        $qId = makeValidInput($_POST['quizId']);
        $step = makeValidInput($_POST['step']);
        if ($sId == -1)
            echo 'لطفا مبحثی را انتخاب نمایید';
        else {
            try {
                $assign = new Assign();
                $assign->subjectId = $sId;
                $assign->step = $step;
                $assign->quizId = $qId;
                $assign->save();
                echo 'مبحث مورد نظر به درستی به مرحله ی انتخابی از آزمون مورد نظر اضافه شد';
            } catch (Exception $e) {
                echo 'مبحث مورد نظر در مرحله ی انتخابی از آزمون مورد نظر موجود است';
            }
        }
    }

    public function getSubjectsByChangingStep()
    {
        $step = makeValidInput($_POST['step']);
        $quizId = makeValidInput($_POST['quizId']);
        $conditions = ['quizId' => $quizId, 'step' => $step];
        $subjects = Assign::where($conditions)->select('assign.subjectId')->get();
        $arr = array();
        $count = 0;
        if (count($subjects) == 0) {
            echo json_encode($arr);
            return;
        }

        foreach ($subjects as $subject) {
            $subjectTmp = Subject::where('id', '=', $subject->subjectId)->get()[0];
            $arr[$count++] = json_encode(array($subjectTmp->name, $subjectTmp->pageStart, $subjectTmp->pageEnd, $subject->subjectId));
        }
        echo json_encode($arr);
    }

    public function getSteps()
    {
        $quizId = makeValidInput($_POST["quizId"]);
        if ($quizId == -1) {
            echo '<option value="-1">مرحله ای موجود نیست</option>';
            return;
        }
        $steps = Quiz::where('id', '=', $quizId)->select('quiz.steps')->get();
        if (count($steps) == 0) {
            echo '<option value="-1">مرحله ای موجود نیست</option>';
            return;
        }
        $steps = $steps[0]->steps;
        for ($i = 1; $i <= $steps; $i++)
            echo "<option value='$i'>$i</option>";
    }

    public function isThisTagProgrammable()
    {
        $tagId = makeValidInput($_POST["tagId"]);
        $scheduleId = makeValidInput($_POST["scheduleId"]);
        $counter = makeValidInput($_POST["counter"]);

        $conditions = ['scheduleId' => $scheduleId, 'counter' => $counter];
        $item = ScheduleItems::where($conditions)->get();
        if (count($item) == 1) {
            $item[0]->tagId = $tagId;
            $item[0]->save();
        }

        $selectedTag = Tag::find($tagId);
        if ($selectedTag->programmable == 1)
            echo 1;
        else
            echo 0;
    }

    public function changeScheduleItem() {
        $scheduleId = makeValidInput($_POST["scheduleId"]);
        $counter = makeValidInput($_POST["counter"]);
        $subjectId = makeValidInput($_POST["subjectId"]);

        $conditions = ['scheduleId' => $scheduleId, 'counter' => $counter];
        $item = ScheduleItems::where($conditions)->get();
        if(count($item) == 1) {
            $item[0]->subjectId = $subjectId;
            $item[0]->save();
        }

    }

    public function getDefaultTagAndSubject(){
        $counter = makeValidInput($_POST["counter"]);
        $scheduleId = makeValidInput($_POST["scheduleId"]);
        $level = makeValidInput($_POST["level"]);

        $conditions = ['counter' => $counter, 'scheduleId' => $scheduleId];
        $item = ScheduleItems::where($conditions)->select('scheduleItem.tagId', 'scheduleItem.subjectId')->get();
        $out = array();
        if (count($item) == 1) {
            if($level == 1 || $level == 2) {
                $out[0] = $item[0]->tagId;
                $out[1] = $item[0]->subjectId;
            }
            else if($level == 3) {
                $out[0] = Tag::find($item[0]->tagId)->tag;
                $tmp = Subject::find($item[0]->subjectId);
                $out[1] = $tmp->name . " از صفحه ی " . $tmp->pageStart . " تا " . $tmp->pageEnd;
            }
            $tag = Tag::find($item[0]->tagId);
            $out[2] = $tag->programmable;
        }
        echo json_encode($out);
    }

    public function deleteSelectedSubjectFromAssign()
    {
        $quizId = makeValidInput($_POST['quizId']);
        $step = makeValidInput($_POST['step']);
        $sId = makeValidInput($_POST['subjectId']);

        $conditions = ['quizId' => $quizId, 'step' => $step, 'subjectId' => $sId];
        Assign::where($conditions)->delete();
    }

    public function getMySchedules() {
        $userId = makeValidInput($_POST["userId"]);
        $level = makeValidInput($_POST["level"]);

        if($level == 1 || $level == 2)
            $schedules = Schedule::where('adviserId', '=', $userId)->select('Schedule.id', 'Schedule.title')->get();
        else
            $schedules = Schedule::where('userId', '=', $userId)->select('Schedule.id', 'Schedule.title')->get();
        foreach ($schedules as $schedule) {
            $str = $schedule->title;
            $out = "سال " . substr($str, 0, 4) . " ماه ";

            if (strlen($str) == 6) {
                switch ($str[4]) {
                    case 1:
                        $out .= "فروردین " . " هفته ی ";
                        break;
                    case 2:
                        $out .= "اردیبهشت " . " هفته ی ";
                        break;
                    case 3:
                        $out .= "خرداد " . " هفته ی ";
                        break;
                    case 4:
                        $out .= "تیر " . " هفته ی ";
                        break;
                    case 5:
                        $out .= "مرداد " . " هفته ی ";
                        break;
                    case 6:
                        $out .= "شهریور " . " هفته ی ";
                        break;
                    case 7:
                        $out .= "مهر " . " هفته ی ";
                        break;
                    case 8:
                        $out .= "آبان " . " هفته ی ";
                        break;
                    case 9:
                        $out .= "آذر " . " هفته ی ";
                        break;
                }
            } else {
                $tmp = substr($str, 4, 2);
                switch ($tmp) {
                    case 10:
                        $out .= "دی " . " هفته ی ";
                        break;
                    case 11:
                        $out .= "بهمن " . " هفته ی ";
                        break;
                    case 12:
                        $out .= "اسفند " . " هفته ی ";
                        break;
                }
            }

            switch ($str[strlen($str) - 1]) {
                case 1:
                    $out .= "اول";
                    break;
                case 2:
                    $out .= "دوم";
                    break;
                case 3:
                    $out .= "سوم";
                    break;
                case 4:
                    $out .= "چهارم";
                    break;
                default:
                    $out .= "پنجم";
                    break;
            }

            echo "<option value='" . $schedule->id . "'>" . $out . "</option>";
        }
    }
    
    public function createPDF() {
        $html = $_POST["html"];
        $html = iconv("utf-8","UTF-8//IGNORE", $html);
        $mpdf = new mPDF('ar','A4','','',5,5,5,5,16,13);
        $mpdf->SetDirectionality('rtl');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    private function parse($in) {
        $out = "";
        for($i = 0; $i < strlen($in); $i++) {
            if(($in[$i] >= 'a' && $in[$i] <= 'z') || ($in[$i] >= 'A' && $in[$i] <= 'Z') || ($in[$i] >= '0' && $in[$i] <= '9'))
                $out .= $in[$i];
        }
        return $out;
    }

    private function getChatId($userId) {

        $token = "298697135:AAG1sTtuaXGvxand-KMonqUl8rkzt_He0rw";
        $str = file_get_contents("https://api.telegram.org/bot$token/getUpdates");

        $str = explode("message_id", $str);

        for($i = 0; $i < count($str); $i++) {
            $tmp = explode("username", $str[$i]);

            if(count($tmp) > 1) {
                for($j = 0; $j < count($tmp); $j++) {
                    $tmp2 = explode("chat", $tmp[$j]);
                    if(count($tmp2) > 1) {
                        for($k = 0; $k < count($tmp2); $k++) {
                            if($k == 0) {
                                if($this->parse($tmp2[$k]) != $userId)
                                    break;
                            }
                            else {
                                $tmp3 = explode("id", $tmp2[$k]);
                                return $this->parse(explode(',', $tmp3[1])[0]);
                            }
                        }
                    }
                }
            }
        }
        return -1;
    }

    public function sendToTelegram() {
        $scheduleId = makeValidInput($_POST["scheduleId"]);
        $html = $_POST["html"];
        $userId = $scheduler = Schedule::find($scheduleId)->userId;
        $telegramUserId = Student::where("id", "=", $userId)->select("userId")->get()[0]->userId;
        $chatId = $this->getChatId($telegramUserId);

        $token = "298697135:AAG1sTtuaXGvxand-KMonqUl8rkzt_He0rw";

        $data = [
            'text' => $html,
            'chat_id' => $chatId
        ];

        $ch = curl_init();

		file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
        echo "برنامه ی مورد نظر به مخاطب ارسال شد";
    }
}