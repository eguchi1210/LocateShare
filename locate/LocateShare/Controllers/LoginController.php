<?php
require_once(ROOT_PATH .'/Models/Login.php');
require_once(ROOT_PATH .'/Models/Locate.php');

class LoginController {
  private $Login;
  private $Signup;
  private $Locate;

  public function __construct() {
    $this ->request['get'] = $_GET;
    $this ->request['post'] = $_POST;

    $this ->Locate = new Locate();

    $dbh = $this ->Locate->get_db_handler();
    $this ->LogIn = new LogIn($dbh);
  }
//テスト用　後でmodel/login と合わせて消す
  public function test_users() {
    $param = $this->LogIn->test();
    return $param;
  }

  // サインアップバリデーション
    public function SignUp_valid() {
      if(isset($_POST['submit'])) {
        $d_name = $this->LogIn->NameDuplicateCheck($_POST['name']);
        $d_mail = $this->LogIn->AddressDuplicateCheck($_POST['mail']);
        require_once('../Signup_valid.php');

        if(empty($judge)) {
          $_SESSION['name'] = $name;
          $_SESSION['mail'] = $mail;
          $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);
          $_SESSION['birth'] = $birth;
          header('Location:/signup_confirm.php');
        } else {
          return $valid;
        }
      }
    }

// サインアップ完了
  public function SignUp_register() {
    $arr = $_SESSION;
    $this ->LogIn->SignUp($arr);
    session_unset();
  }

// サインイン
  public function Signin() {
    $name ='';
    $password ='';

    if(isset($_POST['name'])) {
      $name = $_POST['name'];
    }
    if(isset($_POST['password'])) {
      $password = $_POST['password'];
    }
    $arr = [
      'name' => $name,
      'password' => $password
    ];
    $result = $this->LogIn->UserValid($arr);
    return $result;
  }
  //パスワードリセット認証
  public function reset_input_valid() {
    $mail = $_POST['mail'] ? $_POST['mail'] : '';
    $birth = $_POST['birth'] ? $_POST['birth'] : '';
    $res = $this->LogIn->Mail_Birth_valid($mail, $birth);
    return $res;
  }
  //リセットパスワード更新
  public function password_reset($pass, $mail) {
    $msg = $this->LogIn->Pass_Reset($pass, $mail);
    return $msg;
  }
}
