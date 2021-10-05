<?php
require_once(ROOT_PATH .'/Controllers/LoginController.php');
$Signup = new LoginController;
session_start();
$valid = $Signup ->SignUp_valid();
var_dump($_SESSION);
$mail_v = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$name_v = isset($_SESSION['name']) ? $_SESSION['name'] : '';
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
  <h2>新規ユーザー登録</h2>
  <div class='form'>
    <form action='' method='post'>
      <p>メールアドレス</p>
      <?php if(isset($valid['mail'])): ?>
        <span><?=$valid['mail'];?><br></span>
      <?php endif ?>
      <input type='text' name='mail' value='<?=$mail_v?>' class='textform'></input>
      <p>ユーザー名</p>
      <?php if(isset($valid['name'])): ?>
        <span><?=$valid['name']; ?><br></span>
      <?php endif ?>
      <input type='text' name='name' value='<?=$name_v?>' class='textform'></input>
      <p>生年月日</p>
      <?php if(isset($valid['birth'])):?>
        <span><?=$valid['birth'];?><br></span>
      <?php endif ?>
      <input type='date' name='birth'></input>
      <p>パスワード</p>
      <?php if(isset($valid['password'])): ?>
        <span><?=$valid['password'];?><br></span>
      <?php endif ?>
      <input type='password' name='password' class="textform"></input>
      <input type='submit' name ='submit' value='登録' class='submit_button'><br>
      <div class='login_menu'>
        <a href='login.php'>戻る</a>
      </div>
    </form>
  </div>
  </div>
</body>
