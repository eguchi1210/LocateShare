<?php
require_once(ROOT_PATH .'/Controllers/LoginController.php');
session_start();
$Signup = new LoginController;
$Signup ->SignUp_register();
session_unset();
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
        <p>登録完了しました</p>
        <a href='login.php'>ログインページに戻る</a>
    </div>
  </div>
</body>
