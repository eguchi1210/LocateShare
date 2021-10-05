<?php
$valid_flg = 0;
if(isset($_POST['password'])) {
  //入力内容を変数代入
  $pass = $_POST['password'] ? $_POST['password'] : '';
  $pass_conf = $_POST['password_conf'] ? $_POST['password_conf'] : '';
  //空チェック
  if(empty($pass) or empty($pass_conf)) {
    $valid_flg = 1;
  } else {
    //入力の一致を確認
    if($pass == $pass_conf) {
      $valid_flg = 0;
      session_start();
      $_SESSION['pass'] = password_hash($pass, PASSWORD_DEFAULT);
      header('Location:password_complete.php');
    } else {
      $valid_flg = 1;
    }
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
    <p>新しいパスワード</p>
    <input type='password' name='password' class='textform'><br></input>
    <p>(確認用)パスワード</p>
    <input type='password' name='password_conf' class='textform'><br></input>
    <input type='submit' value='送信' class='submit_button'>
  </form>
</div>
</div>
