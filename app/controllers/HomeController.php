<?php

//require __DIR__.'../../vendor/autoload.php';
//use Dompdf\Dompdf;

class HomeController extends BaseController {

	public function home() {
		return View::make('home');
	}

	public function addAdviser() {
		return View::make('addNewUser', array('mode' => 'adviser', 'name' => '',
			'family' => '', 'userName' => '', 'pas' => '', 'phoneNum' => '', 'msg' => ''));
	}

	public function doAddAdviser() {
		$name = makeValidInput(Input::get('name'));
		$family = makeValidInput(Input::get('family'));
		$userName = makeValidInput(Input::get('userName'));
		$phoneNum = makeValidInput(Input::get('phoneNum'));

		$count = User::where('username', '=', $userName)->count();
		if($count > 0) {
			$msg = 'کاربری با نام کاربری وارد شده در سامانه موجود است';
			return View::make('addNewUser', array('mode' => 'adviser'), array('name' => $name,
				'family' => $family, 'userName' => $userName, 'pas' => '', 'phoneNum' => $phoneNum, 'msg' => $msg));
		}

		$pas = makeValidInput(Hash::make(Input::get('pas')));
		$user = new User();
		$user->name = $name;
		$user->username = $userName;
		$user->password = $pas;
		$user->phoneNum = $phoneNum;
		$user->family = $family;
		$user->level = 2;
		$user->save();
		return Redirect::to('home');
	}

	public function login() {
		return View::make('login', array('msg' => ''));
	}

	public function doLogin() {

		$username = makeValidInput(Input::get('username'));
		$password = makeValidInput(Input::get('password'));
		if(Auth::attempt(array('username' => $username, 'password' => $password))) {
			$a = User::where('username', '=', $username)->select('user.level', 'user.id')->get();
//			if($a[0]->level == '3') {
//				$msg = 'شما اجازه ی ورود به سیستم را ندارید';
//				return View::make('login', array('msg' => $msg));
//			}
			Session::put('level', $a[0]->level);
			Session::put('uId', $a[0]->id);
			return Redirect::intended('/');
		}
		else {
			$msg = 'نام کاربری و یا پسورد اشتباه است';
			return View::make('login', array('msg' => $msg));
		}
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('login');
	}

	public function addTag() {
		$tags = Tag::all();
		return View::make('addTag', array('tags' => $tags, 'tag' => '', 'msg' => ''));
	}

	public function doOpOnTag() {
		if(isset($_POST['addNewTag'])) {
			$tag = makeValidInput(Input::get('tag'));
			try {
				$newTag = new Tag();
				$newTag->tag = $tag;
				if(isset($_POST["programmable"]))
					$newTag->programmable = 1;
				$newTag->save();
				$tag = '';
				$msg = 'تگ وارد شده در سامانه ثبت شده است';
			}
			catch (Exception $e) {
				$msg = 'تگ وارد شده در سیستم موجود است';
			}

		}
		else if(isset($_POST['deleteSelected'])) {
			$tagId = makeValidInput(Input::get('deleteSelected'));
			$msg = 'تگ مورد نظر به درستی از سیستم حذف شد';
			$tag = '';
			Tag::destroy($tagId);
		}

		$tags = Tag::all();
		return View::make('addTag', array('tags' => $tags, 'tag' => $tag, 'msg' => $msg));
	}

	public function addStudent() {

		$degrees = Degree::all();

		return View::make('addNewUser', array('mode' => 'student', 'name' => '',
			'family' => '', 'userName' => '', 'pas' => '', 'phoneNum' => '', 'chatId' => '', 'parentPhoneNum' => '',
			'email' => '', 'degrees' => $degrees, 'selectedDegree' => '', 'msg' => ''));
	}

	public function doAddStudent() {

		if(!isset($_POST["addNewStudent"])) {
			$msg = 'اشکالی در ارتباط با سرور رخ داده است (خطای 104)';
			$degrees = Degree::all();

			return View::make('addNewUser', array('mode' => 'student', 'name' => '',
				'family' => '', 'userName' => '', 'pas' => '', 'phoneNum' => '', 'chatId' => '', 'parentPhoneNum' => '',
				'email' => '', 'degrees' => $degrees, 'selectedDegree' => '', 'msg' => $msg));
		}

		$name = makeValidInput(Input::get('name'));
		$family = makeValidInput(Input::get('family'));
		$phoneNum = makeValidInput(Input::get('phoneNum'));
		$parentPhoneNum = makeValidInput(Input::get('parentPhoneNum'));
		$userName = makeValidInput(Input::get('userName'));
		$pas = Hash::make(makeValidInput(Input::get('pas')));
		$chatId = makeValidInput(Input::get('chatId'));
		$email = makeValidInput(Input::get('email'));
		$selectedDegree = makeValidInput(Input::get('selectedDegree'));

		try {
			$newUser = new User();
			$newUser->name = $name;
			$newUser->family = $family;
			$newUser->username = $userName;
			$newUser->password = $pas;
			$newUser->phoneNum = $phoneNum;
			$newUser->level = 3;
			$newUser->save();

			$newStudent = new Student();
			$newStudent->id = $newUser->id;
			$newStudent->parentPhoneNum = $parentPhoneNum;
			$newStudent->email = $email;
			$newStudent->chatId = $chatId;
			$newStudent->degree = $selectedDegree;

			$newStudent->adviserId = Session::get('uId', '1');
			$newStudent->save();

			return Redirect::to('home');
		}
		catch (Exception $e) {

			User::where('username', '=', $userName)->delete();

			$msg = 'نام کاربری  و یا chat id وارد شده در سامانه موجود است';
			$degrees = Degree::all();

			return View::make('addNewUser', array('mode' => 'student', 'name' => $name,
				'family' => $family, 'userName' => $userName, 'pas' => '', 'phoneNum' => $phoneNum,
				'chatId' => $chatId, 'parentPhoneNum' => $parentPhoneNum,
				'email' => $email, 'degrees' => $degrees, 'selectedDegree' => $selectedDegree, 'msg' => $msg));
		}
	}

//	public function sendMessage() {
//		$token = "298697135:AAG1sTtuaXGvxand-KMonqUl8rkzt_He0rw";
//
//		$data = [
//			'text' => 'your message here',
//			'chat_id' => '88737881'
//		];
//
////		echo file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
//		$str = file_get_contents("https://api.telegram.org/bot$token/getUpdates");
//
//		$str = explode("message_id", $str);
//
//		for($i = 0; $i < count($str); $i++) {
//			$tmp = explode("username", $str[$i]);
//
//			if(count($tmp) > 1) {
//				for($j = 0; $j < count($tmp); $j++) {
//					$tmp2 = explode("chat", $tmp[$j]);
//					if(count($tmp2) > 1) {
//						for($k = 0; $k < count($tmp2); $k++) {
//							if($k == 0) {
//								echo "username is " . $this->parse($tmp2[$k]) . " <br/>";
//								if($this->parse($tmp2[$k]) != "mazidimojgan")
//									break;
//							}
//							else {
//								$tmp3 = explode("id", $tmp2[$k]);
//								echo $this->parse(explode(',', $tmp3[1])[0]) . "<br/>";
//							}
//						}
//					}
//				}
//			}
//		}
//	}
}
