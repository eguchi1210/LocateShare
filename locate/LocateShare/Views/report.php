<?php
require_once(ROOT_PATH .'/Controllers/LocateController.php');
require_once('../login_check.php');
require_once('../head.php');

$Locate = new LocateController;
$arr = $Locate->detail();
$msg = $Locate->report_complete($arr['id'], $arr['user_id']);
?>

<h2>管理者への報告</h2>
<p><?=$msg ?></p>

<a href='/index.php'>マイページに戻る</a>
