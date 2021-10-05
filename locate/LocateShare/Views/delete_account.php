<?php
require_once(ROOT_PATH .'/Controllers/AdminController.php');
require_once('../login_check.php');
require_once('../head.php');

if($_SESSION['user']['role'] != 1) {
  header('Location:index.php');
}

$Admin = new AdminController;
$msg = $Admin->nullify_account();

?>

<h2>アカウント処理</h2>
<p><?=$msg[0] ?></p>
<h2>投稿処理</h2>
<p><?=$msg[1] ?></p>
<a href='/index.php'>戻る</a>
