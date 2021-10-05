<?php
require_once(ROOT_PATH .'/Controllers/LoginController.php');
session_start();
$Signup = new LoginController;
$msg = $Signup ->password_reset($_SESSION['pass'], $_SESSION['mail']);

//リファラチェック(確認画面以外からの流入は弾いてindexへ)
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if(parse_url($referer, PHP_URL_PATH) != '/password_reset.php') {
  header('Location:index.php');
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

  <h2>パスワードリセット</h2>
  <p><?=$msg ?></p>

  <a href='login.php'>ログインページに戻る</a>
