<?php
require_once(ROOT_PATH .'/Controllers/LoginController.php');
$Login = new LoginController;

$valid_flg = 0;
if(isset($_POST['mail'])) {
  $res = $Login->reset_input_valid();
  if($res) {
    $valid_flg = 0;
    session_start();
    $_SESSION['mail'] = $_POST['mail'];
    header('Location:password_reset.php');
  } else {
    $valid_flg = 1;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <title>Locate Share</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div class='input'>
  <h2>パスワードリセット</h2>
  <div class='form'>
    <?php if($valid_flg == 1): ?>
      <span>入力内容に誤りがあります</span>
    <?php endif ?>
  <form action='' method='post'>
    <p>メールアドレス</p>
    <input type='text' name='mail' class='textform'></input>
    <p>生年月日</p>
    <input type='date' name='birth' class=''><br></input>
    <input type='submit' value='送信' class='submit_button'>
  </form>
  <div class='login_menu'>
    <a href='login.php'>戻る</a>
  </div>
</div>
</div>
