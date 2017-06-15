<?php

class ReportHandler extends BaseController {

    public function grades() {
        $degrees = Degree::all();
        return View::make('degrees', array('mode' => 'see', 'msg' => '', 'degrees' => $degrees));
    }

    public function opOnGrades() {
        $msg = '';
        if (isset($_POST["addNewDegree"])) {
            $degree = makeValidInput(Input::get('degree'));
            if (empty($degree))
                $msg = 'لطفا نامی به عنوان نام پایه ی تحصیلی وارد نمایید';
            else {
                try{
                    $newDegree = new Degree();
                    $newDegree->degree = $degree;
                    $newDegree->save();
                    $msg = 'پایه ی تحصیلی مورد نظر به درستی به سیستم اضافه شد';
                }
                catch (Exception $e) {
                    $msg = 'پایه ی تحصیلی وارد شده در سامانه موجود است';
                }
            }
        }
        else if(isset($_POST['deleteSelected'])) {
            $did = makeValidInput(Input::get('deleteSelected'));
            Degree::destroy($did);
            $msg = 'پایه ی تحصیلی مورد نظر به درستی از سامانه حذف گردید';
        }
        else if(isset($_POST["editSelected"])) {
            $did = makeValidInput(Input::get('editSelected'));
            $dN = Degree::where('id', '=', $did)->select('degree.degree')->get()[0]->degree;
            return View::make('degrees', array('mode' => 'edit', 'did' => $did, 'dN' => $dN, 'msg' => ''));
        }
        else if(isset($_POST["doEdit"])) {
            $did = makeValidInput(Input::get('did'));
            $dN = makeValidInput(Input::get('newDegree'));
            try{
                $newDegree = Degree::find($did);
                $newDegree->degree = $dN;
                $newDegree->save();
                $msg = 'پایه ی تحصیلی مورد نظر به درستی ویرایش شد';
            }
            catch(Exception $e) {
                $dN = Degree::where('id', '=', $did)->select('degree.degree')->get()[0]->degree;
                $msg = 'پایه ی تحصیلی وارد شده در سیستم موجود است';
                return View::make('degrees', array('mode' => 'edit', 'did' => $did, 'dN' => $dN, 'msg' => $msg));
            }
        }
        $degrees = Degree::all();
        return View::make('degrees', array('mode' => 'see', 'msg' => $msg, 'degrees' => $degrees));
    }

    public function subjects() {
        $degrees = Degree::all();
        return View::make('subjects', array('mode' => 'see', 'pageStart' => '1', 'pageEnd' => '2',
            'selectedDegree' => '', 'degrees' => $degrees, 'msg' => '', 'subjectName' => '', 'selectedLesson' => ''));
    }

    public function opOnSubjects() {
        $selectedDegree = '';
        $selectedLesson = '';
        $pageStart = 1;
        $pageEnd = 2;
        $subjectName = '';

        if(isset($_POST["addNewSubject"])) {
            $degreeId = makeValidInput(Input::get('selectedDegree'));
            $lId = makeValidInput(Input::get('selectedLesson'));
            $subject = makeValidInput(Input::get('subject'));
            $pageStart = makeValidInput(Input::get('pageStart'));
            $pageEnd = makeValidInput(Input::get('pageEnd'));
            $subjectName = $subject;

            $selectedDegree = $degreeId;
            $selectedLesson = $lId;

            if(empty($subject))
                $msg = 'لطفا نامی برای مبحث مورد نظر انتخاب نمایید';
            else if($pageStart > $pageEnd)
                $msg = 'صفحه ی پایان باید بزرگ تر یا مساوی صفحه ی آغاز باشد';
            else {
                try {
                    $newSubject = new Subject();
                    $newSubject->name = $subject;
                    $newSubject->lid = $lId;
                    $newSubject->pageStart = $pageStart;
                    $newSubject->pageEnd = $pageEnd;
                    $newSubject->save();
                    $subjectName = '';
                    $msg = 'مبحث مورد نظر به پایه ی تحصیلی و درس مورد نظر اضافه شد';
                } catch (Exception $e) {
                    $msg = 'مبحث مورد نظر در پایه ی تحصیلی و درس مورد نظر وجود دارد';
                }
            }
        }

        else if(isset($_POST['deleteSelected'])) {
            $sid = makeValidInput(Input::get('deleteSelected'));
            $selectedDegree = makeValidInput(Input::get('selectedDegree'));
            $selectedLesson = makeValidInput(Input::get('selectedLesson'));
            Subject::destroy($sid);
            $msg = 'مبحث مورد نظر به درستی از سیستم حذف شد';
        }

        else if(isset($_POST['editSelected'])) {
            $degrees = Degree::all();
            $sid = makeValidInput(Input::get('editSelected'));
            $selectedDegree = makeValidInput(Input::get('selectedDegree'));
            $selectedLesson = makeValidInput(Input::get('selectedLesson'));
            $subject = Subject::where('id', '=', $sid)->get()[0];
            $subjectName = $subject->name;
            $pageStart  = $subject->pageStart;
            $pageEnd  = $subject->pageEnd;
            return View::make('subjects', array('mode' => 'edit', 'name' => $subjectName, 'selectedDegree' => $selectedDegree,
                'selectedLesson' => $selectedLesson, 'selectedSubject' => $sid, 'degrees' => $degrees, 'msg' => '',
                'pageStart' => $pageStart, 'pageEnd' => $pageEnd));
        }
        else if(isset($_POST['doEditSubject'])) {
            $selectedDegree = makeValidInput(Input::get('newSelectedDegree'));
            $lId = makeValidInput(Input::get('newSelectedLesson'));
            $newSubjectName = makeValidInput(Input::get('newSubjectName'));
            $sId = makeValidInput(Input::get('selectedSubject'));
            $pageStart = makeValidInput(Input::get('pageStart'));
            $pageEnd = makeValidInput(Input::get('pageEnd'));
            $selectedLesson = $lId;
            try{
                $subject = Subject::find($sId);
                $subject->name = $newSubjectName;
                $subject->lid = $lId;
                $subject->pageStart = $pageStart;
                $subject->pageEnd = $pageEnd;
                $subject->save();
                $msg = 'درس مورد نظر به درستی ویرایش شد';
                $pageEnd = 2;
                $pageStart = 1;
            }
            catch (Exception $e) {
                $msg = 'مبحث مورد نظر در سیستم موجود است';
                $subject = Subject::where('id', '=', $sId)->get()[0];
                $subjectName = $subject->name;
                $selectedLesson = $subject->lid;
                $pageStart = $subject->pageStart;
                $pageEnd = $subject->pageEnd;
                $selectedDegree = Lesson::where('id', '=', $selectedLesson)->select('lesson.did')->get()[0]->did;
                $degrees = Degree::all();

                return View::make('subjects', array('mode' => 'edit', 'name' => $subjectName, 'selectedDegree' => $selectedDegree,
                    'selectedLesson' => $selectedLesson, 'selectedSubject' => $sId, 'degrees' => $degrees, 'msg' => $msg,
                    'pageStart' => $pageStart, 'pageEnd' => $pageEnd));
            }
        }
        else
            $msg = 'مشکلی در برقراری ارتباط با سیستم به وجود آمده است';

        $degrees = Degree::all();
        return View::make('subjects', array('mode' => 'see', 'subjectName' => $subjectName, 'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
            'selectedDegree' => $selectedDegree, 'degrees' => $degrees, 'msg' => $msg, 'selectedLesson' => $selectedLesson));
    }

    public function stages() {
        $quizes = Quiz::all();
        $degrees = Degree::all();
        return View::make('stages', array('quizes' => $quizes, 'degrees' => $degrees));
    }

    public function quizes() {
        $quizes = Quiz::all();
        return View::make('quizes', array('mode' => 'see', 'quizes' => $quizes, 'msg' => ''));
    }

    public function opOnQuiz() {

        if(isset($_POST["addNewQuiz"])) {
            $name = makeValidInput(Input::get('quizName'));
            $steps = makeValidInput(Input::get('steps'));
            if(empty($name))
                $msg = 'لطفا نامی به عنوان آزمون خود انتخاب نمایید';
            else {
                try {
                    $quiz = new Quiz();
                    $quiz->name = $name;
                    $quiz->steps = $steps;
                    $quiz->save();
                    $msg = 'آزمون مورد نظر به درستی به سیستم اضافه شد';
                } catch (Exception $e) {
                    $msg = 'آزمون وارد شده در سیسستم موجود است';
                }
            }
        }
        else if(isset($_POST["deleteSelected"])) {
            $qId = makeValidInput(Input::get('deleteSelected'));
            Quiz::destroy($qId);
            $msg = 'آزمون مورد نظر به درستی از سیستم حذف شد';
        }
        else if(isset($_POST["editSelected"])) {
            $quiz = Quiz::find(makeValidInput(Input::get('editSelected')));
            return View::make('quizes', array('mode' => 'edit', 'quiz' => $quiz, 'msg' => ''));
        }
        else if(isset($_POST["doEditQuiz"])) {
            $quiz = Quiz::find(makeValidInput(Input::get('quizId')));
            $newQuizName = makeValidInput(Input::get('newQuizName'));
            if(empty($newQuizName)) {
                $msg = 'لطفا نامی را به عنوان نام آزمون برگزینید';
                return View::make('quizes', array('mode' => 'edit', 'quiz' => $quiz, 'msg' => $msg));
            }
            $tmp = $quiz->name;
            $quiz->name = $newQuizName;
            try {
                $quiz->save();
                $msg = 'تغییر نام آزمون به درستی انجام پذیرفت';
            }
            catch (Exception $x) {
                $quiz->name = $tmp;
                $msg = 'آزمونی با همین نام در سامانه موجود است';
            }
            return View::make('quizes', array('mode' => 'edit', 'quiz' => $quiz, 'msg' => $msg));
        }
        else if(isset($_POST["deleteSelectedStep"])) {
            $step = makeValidInput(Input::get('deleteSelectedStep'));
            $quiz = Quiz::find(makeValidInput(Input::get('quizId')));
            $conditions = ['step' => $step, 'quizId' => $quiz->id];
            Assign::where($conditions)->delete();
            $quiz->steps = $quiz->steps - 1;
            $quiz->save();
            $msg = 'مرحله ی مورد نظر به درستی از آزمون مورد نظر حذف شد و مراحل ازنو چیده شدند';
            return View::make('quizes', array('mode' => 'edit', 'quiz' => $quiz, 'msg' => $msg));
        }
        else if(isset($_POST["addNewStep"])) {
            $quiz = Quiz::find(makeValidInput(Input::get('quizId')));
            $quiz->steps = $quiz->steps + 1;
            $quiz->save();
            $msg = 'مرحله ی جدید به آزمون مورد نظر اضافه شده است';
            return View::make('quizes', array('mode' => 'edit', 'quiz' => $quiz, 'msg' => $msg));
        }
        else
            $msg = 'خطایی در برقراری ارتباط با سیستم به وجود آمده است';

        $quizes = Quiz::all();
        return View::make('quizes', array('mode' => 'see', 'quizes' => $quizes, 'msg' => $msg));
    }
}