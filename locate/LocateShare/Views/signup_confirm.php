<?php
require_once(ROOT_PATH .'/Controllers/LoginController.php');
$Signup = new LoginController;

session_start();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <title>新規登録</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div class='input'>
  <div class='form'>
    <h2>新規ユーザー登録</h2>
      <p>メールアドレス<br><?=$_SESSION['mail'] ?></p>
      <p>ユーザー名<br><?=$_SESSION['name']?></p>
      <p>パスワード<br>*********</p>
      <a href='signup_complete.php'><button class='submit_button'>登録</button></a><br>
      <a href="signup.php">修正</a>
    </div>
  </div>
</body>
